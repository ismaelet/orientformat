<?php

namespace App\Models\Schools;

use App\Helpers\ClassHelper;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class SchoolClass extends Model {

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'schoolId',
        'referentId',
        'grade_level_id',
        'name',
        'grade',
        'startingGrade',
        'letter',
        'code',
        'startingYear',
        'year',
        'ended',
        'professional',
    ];

    /**
     * Attribute: The class's first grade
     */
    public function firstGrade(): Attribute {
        return Attribute::make(
            get: fn() => $this->isMiddleSchool() ? Grade::MIDDLE_SCHOOL_GRADES[0] : Grade::HIGH_SCHOOL_GRADES[0]
        );
    }

    /**
     * Attribute: The class's last grade
     */
    public function lastGrade(): Attribute {
        return Attribute::make(
            get: fn() => $this->isMiddleSchool() ? Grade::MIDDLE_SCHOOL_GRADES[count(Grade::MIDDLE_SCHOOL_GRADES) - 1] : ($this->professional ? Grade::PROFESSIONAL_GRADES[count(Grade::PROFESSIONAL_GRADES) - 1] : Grade::HIGH_SCHOOL_GRADES[count(Grade::HIGH_SCHOOL_GRADES) - 1])
        );
    }

    public function currentGrade(): Attribute {
        return Attribute::make(
            get: fn() => $this->grade
        );
    }

    /**
     * Relationship: The school the class belongs to
     */
    public function school(): BelongsTo {
        return $this->belongsTo(School::class, 'schoolId');
    }

    /**
     * Relationship: The school the class belongs to
     * 
     * ! Legacy
     */
    public function referent(): BelongsTo {
        return $this->belongsTo(Teacher::class, 'referentId');
    }

    /**
     * Relationship: The school the class belongs to
     */
    public function tutor(): BelongsTo {
        return $this->belongsTo(Teacher::class, 'referentId');
    }

    /**
     * Relationship: The teachers in the class
     */
    public function teachers(): BelongsToMany {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * Relationship: The students in the class
     */
    public function students(): HasMany {
        return $this->hasMany(Student::class, 'schoolClassId');
    }

    /**
     * Relationship: The students in the class
     */
    public function active_students(): HasMany {
        return $this->hasMany(Student::class, 'schoolClassId')->where('status', true);
    }

    /**
     * Relationship: The grade level of the class
     */
    public function grade_level(): BelongsTo {
        return $this->belongsTo(Grade::class, 'grade_level_id');
    }

    /**
     * Grade
     * 
     * ! NOT A RELATIONSHIP
     */
    public function grade(): ?Grade {
        return Grade::getByNumber($this->grade, $this->professional);
    }

    /**
     * Get the available grades for the class
     */
    public function availableGrades(): Collection {
        $grades = collect();

        foreach ($this->gradeNumbers() as $gradeNumber) {
            $grade = Grade::getByNumber($gradeNumber, $this->professional);

            if ($grade) {
                $grades->push($grade);
            }
        }

        return $grades;
    }

    /**
     * Get the class's url
     */
    public function url(): string {
        return route('class.show', ['class' => $this->id]);
    }

    /**
     * Check if the class is in middle school
     */
    public function isMiddleSchool(): bool {
        return $this->startingGrade < 4;
    }

    /**
     * Check if the class is in high school
     */
    public function isHighSchool(): bool {
        return $this->startingGrade > 3;
    }

    /**
     * Get the last active year
     */
    function lastActiveYear(): int {
        return $this->year;
    }

    /**
     * Get the year range string
     */
    public function yearRangeString(): string {
        return $this->lastActiveYear() . ' - ' . ($this->lastActiveYear() + 1);
    }

    /**
     * Get grade numbers
     */
    public function gradeNumbers(): array {
        if ($this->professional) {
            return range(4, 7);
        }

        if ($this->isHighSchool()) {
            return range(4, 8);
        }

        return range(1, 3);
    }

    /**
     * Check if the class has a grade
     */
    public function hasGrade(int $gradeNumber): bool {
        return in_array($gradeNumber, $this->gradeNumbers());
    }

    /**
     * Get the grade number at a specific date
     */
    public function gradeWhen(int $year): int {
        $diffYear = $year - $this->startingYear;

        return max($this->first_grade, min($this->startingGrade + $diffYear, $this->last_grade));
    }

    /**
     * Get the grade level at a specific date
     */
    public function gradeLevelAt(int $year): ?Grade {
        $gradeNumber = $this->gradeWhen($year);

        return Grade::getByNumber($gradeNumber, $this->professional);
    }

    /**
     * Check if the class was active in a specific year
     */
    public function wasActiveInYear(int $year): bool {
        return $year >= $this->startingYear && $year <= $this->lastActiveYear();
    }

    /**
     * Check if the class is part of a professional school
     */
    public function isProfessional(): bool {
        return $this->professional;
    }

    /**
     * Get the class's full name
     */
    public function fullName(): string {
        return $this->name . ' (' . ($this->year) . '-' . ($this->year + 1)
            . ')';
    }

    /**
     * Create a new class from data
     */
    public static function createFromData(array $data = []): SchoolClass|RedirectResponse {
        $letter = strtoupper($data['letter']);
        $referentId = teacher()->id ?: administrator()->id;
        $code = bin2hex(random_bytes(5));
        $startingYear = (date('n') < 9) ? date('Y', strtotime('-1 year')) : date('Y');
        $name = ClassHelper::generateName($data['grade'], $letter);
        $letter = $data['grade'] < 4 ? preg_replace('/\d/', '', $letter) : $letter;

        while (SchoolClass::where('code', $code)->exists()) {
            $code = bin2hex(random_bytes(5));
        }

        if (SchoolClass::where('schoolId', $data['schoolId'])
            ->where('grade', $data['grade'])
            ->where('letter', $letter)
            ->where('ended', false)
            ->exists()
        ) {
            return back()->withErrors(['duplicate' => "Esiste già una classe {$name} in questo istituto."])->withInput();
        }

        $class = SchoolClass::create([
            'name' => $name,
            'schoolId' => $data['schoolId'],
            'referentId' => $referentId,
            'grade' => $data['grade'],
            'startingGrade' => $data['grade'],
            'letter' => $letter,
            'code' => $code,
            'startingYear' => $startingYear,
            'year' => $startingYear,
            'professional' => $data['professional'] ?? false,
        ]);

        teacher()->school_classes()->attach($class->id);

        return $class;
    }
}

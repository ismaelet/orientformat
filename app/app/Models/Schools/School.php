<?php

namespace App\Models\Schools;

use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Property: The attributes that are mass assignable
     */
    protected $fillable = [
        'name',
        'has_high_school',
    ];

    /**
     * Relationship: The classes that belong to the school
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'schoolId')->orderByDesc('year')->orderByDesc('grade')->orderBy('letter');
    }

    /**
     * Relationship: The classes that belong to the school
     *
     * ! Legacy
     */
    public function school_classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'schoolId')->orderByDesc('year')->orderByDesc('grade')->orderBy('letter');
    }

    /**
     * Relationship: The teachers that belong to the school
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Relationship: The students that belong to the school
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, SchoolClass::class, 'schoolId', 'schoolClassId');
    }
}

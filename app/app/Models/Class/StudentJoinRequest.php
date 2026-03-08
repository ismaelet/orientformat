<?php

namespace App\Models\Class;

use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentJoinRequest extends Model {

    /**
     * The table associated with the models
     */
    protected $table = 'student_join_requests';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'requesting_student_id',
        'class_id',
    ];

    /**
     * Relationship: The student who requested to join the class
     */
    public function requesting_student(): BelongsTo {
        return $this->belongsTo(Student::class, 'requesting_student_id');
    }

    /**
     * Relationship: The class associated with the join request
     */
    public function class(): BelongsTo {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the tutor teacher for the join request
     */
    public function tutor(): ?Teacher {
        return $this->class?->tutor;
    }
}

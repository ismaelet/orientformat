<?php

namespace App\Models\User;

use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrator extends Model
{
    /**
     * Property: The attributes that are mass assignable
     */
    protected $fillable = [
        'user_id',
        'school_id',
    ];

    /**
     * Relationship: The user the administrator belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: The school the administrator belongs to
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Relationship: The students that the administrator is responsible for
     */
    public function students(): Collection
    {
        return $this->school->students;
    }

    /**
     * The IDs of the students that the administrator is responsible for
     */
    public function studentIds(): array
    {
        return $this->students()->pluck('id')->toArray();
    }

    /**
     * Check if the administrator has access to a specific class
     */
    public function hasAccessToClass(SchoolClass $class): bool
    {
        return $this->school->classes?->where('id', $class->id)->count();
    }
}

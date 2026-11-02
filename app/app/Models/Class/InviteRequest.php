<?php

namespace App\Models\Class;

use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InviteRequest extends Model
{
    /**
     * The table associated with the models
     */
    protected $table = 'class_invite_requests';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'inviting_teacher_id',
        'invited_teacher_id',
        'class_id',
    ];

    /**
     * Relationship: The teacher who was invited to join the class
     */
    public function inviting_teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'inviting_teacher_id');
    }

    /**
     * Relationship: The teacher who was invited to join the class
     */
    public function invited_teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'invited_teacher_id');
    }

    /**
     * Relationship: The class associated with the invite request
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}

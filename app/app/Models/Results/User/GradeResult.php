<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class GradeResult extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'results_grades';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'studentId',
        'gradeId',
        'progressPercentage',
    ];
}

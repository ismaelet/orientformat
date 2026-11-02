<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class CondensedSectionResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'results_sections_condensed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'section_id',
        'result',
        'speed',
    ];
}

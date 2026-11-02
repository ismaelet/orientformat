<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class PermanentResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'results_permanent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studentId',
        'testId',
        'result',
        'percentage',
        'speed',
        'timesNumber',
    ];
}

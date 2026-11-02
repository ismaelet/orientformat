<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class AdditionalResult extends Model
{
    /**
     * The table associated with the model
     */
    protected $table = 'results_additional';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'studentId',
        'testId',
        'primaryResults',
        'secondaryResults',
    ];
}

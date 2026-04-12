<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class OtherResult extends Model {

    /**
     * The table associated with the model
     */
    protected $table = 'results_others';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'userID',
        'testID',
        'result',
    ];
}

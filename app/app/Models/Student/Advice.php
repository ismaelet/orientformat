<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'advices',
    ];
}

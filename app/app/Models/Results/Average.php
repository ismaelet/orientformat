<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model;

/**
 * Platform average
 */
class Average extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = ['sectionId', 'value'];
}

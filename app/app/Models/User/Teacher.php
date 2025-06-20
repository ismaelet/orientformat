<?php

namespace App\Models\User;

use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model {

	/**
	 * Property: The attributes that are mass assignable
	 */
	protected $fillable = [
		'user_id',
		'school_id',
	];

	/**
	 * Relationship: The user associated with this teacher
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	/**
	 * Relationship: The school where this teacher currently works
	 */
	public function school(): BelongsTo {
		return $this->belongsTo(School::class);
	}

	/**
	 * Relationship: The classes this teacher is assigned to
	 */
	public function school_classes(): BelongsToMany {
		return $this->belongsToMany(SchoolClass::class);
	}
}

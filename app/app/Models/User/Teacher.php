<?php

namespace App\Models\User;

use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model {

	use HasFactory, SoftDeletes;

	/**
	 * Property: The attributes that are mass assignable
	 */
	protected $fillable = [
		'id',
		'user_id',
		'school_id',
	];

	/**
	 * Attribute: Get the teacher's first name
	 */
	public function firstName(): Attribute {
		return new Attribute(
			get: fn() => $this->user?->first_name,
		);
	}

	/**
	 * Attribute: Get the teacher's last name
	 */
	public function lastName(): Attribute {
		return new Attribute(
			get: fn() => $this->user?->last_name,
		);
	}

	/**
	 * Attribute: Get the teacher's full name
	 */
	public function fullName(): Attribute {
		return new Attribute(
			get: fn() => $this->user?->full_name,
		);
	}

	/**
	 * Attribute: Get the teacher's full name (inverted)
	 */
	public function invertedFullName(): Attribute {
		return new Attribute(
			get: fn() => $this->user?->inverted_full_name,
		);
	}

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

	/**
	 * Check if the teacher has access to a specific class
	 */
	public function hasAccessToClass(SchoolClass $class): bool {
		return $this->school_classes->pluck('id')->contains($class->id);
	}

	/**
	 * Get the IDs of all students in the classes taught by this teacher
	 */
	public function studentIds(): array {
		return $this->school_classes->flatMap(function (SchoolClass $class) {
			return $class->students->pluck('id');
		})->unique()->values()->all();
	}
}

<?php

namespace App\Models\User;

use App\Models\Schools\SchoolClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'created_at'
	];

	/**
	 * * Accessors
	 */
	public function getSchoolClassIdsAttribute(): array {
		return $this->classes ? array_filter(explode(',', $this->classes)) : [];
	}

	/**
	 * * Relationships
	 */

	/**
	 * School classes
	 *
	 * ! NOT A RELATIONSHIP
	 */
	public function school_classes(): Collection {
		return SchoolClass::whereIn('id', $this->school_class_ids)
			->orderBy('year', 'desc')
			->orderBy('grade', 'desc')
			->get();
	}

	/**
	 * School classes count
	 */
	public function schoolClassesCount(): int {
		return $this->school_classes()->count();
	}
}

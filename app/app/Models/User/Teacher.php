<?php

namespace App\Models\User;

use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model {

	/**
	 * The primary key associated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'userId';

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'classes',
		'created_at',
	];

	/**
	 * Get the school class ids
	 * 
	 * @return array
	 */
	public function getSchoolClassIdsAttribute(): array {
		return $this->classes ? array_filter(explode(',', $this->classes)) : [];
	}

	/**
	 * Get the user associated with the teacher
	 * 
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'userId');
	}

	/**
	 * School classes
	 *
	 * ! NOT A RELATIONSHIP
	 */
	public function school_classes(): Collection {
		return SchoolClass::whereIn('id', $this->school_class_ids)
			->with('school')
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

	public function schools(): Collection {
		return $this->school_classes()
			->load('school')
			->map(function ($schoolClass) {
				return $schoolClass->school;
			})->unique();
	}
}

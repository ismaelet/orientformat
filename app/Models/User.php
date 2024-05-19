<?php

namespace App\Models;

use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * * Relationships
	 */

	/**
	 * Get the student record associated with the user
	 */
	public function student(): HasOne {
		return $this->hasOne(Student::class, 'userId');
	}

	/**
	 * Get the teacher record associated with the user
	 */
	public function teacher(): HasOne {
		return $this->hasOne(Teacher::class, 'userId');
	}

	/**
	 * * Attributes
	 */

	/**
	 * Get the user's full name
	 */
	public function fullName(): string {
		$fullName = [];
		$fullName[] = $this->first_name;
		$fullName[] = $this->last_name;

		return implode(' ', $fullName);
	}

	/**
	 * Check if the user is an admin
	 */
	public function isAdmin(): bool {
		return (bool) $this->admin_level;
	}

	/**
	 * Check if the user is an admin
	 */
	public function isSupervisor(): bool {
		return (bool) $this->admin_level == 2;
	}

	/**
	 * Check if the user is a student
	 */
	public function isStudent(): bool {
		return (bool) $this->student;
	}

	/**
	 * Check if the user is a highschool student
	 */
	public function isHighschoolStudent(): bool {
		return $this->student && $this->student->isHighschoolStudent();
	}

	/**
	 * Check if the user is a teacher
	 */
	public function isTeacher(): bool {
		return (bool) $this->teacher;
	}
}

<?php

namespace App\Models;

use App\Models\User\Administrator;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

	use HasFactory, Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'created_at',
		'active',
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
	 * Get the administrator record associated with the user
	 * 
	 * @return HasOne
	 */
	public function administrator(): HasOne {
		return $this->hasOne(Administrator::class);
	}

	/**
	 * * Attributes
	 */

	/**
	 * Get the user's full name
	 */
	public function fullName(): string {
		$fullName = [];
		$fullName[] = $this->firstName;
		$fullName[] = $this->lastName;

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
	public function isSuperadmin(): bool {
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

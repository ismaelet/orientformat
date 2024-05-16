<?php

namespace App\Models;

use App\Models\Ecommerce\Cart;
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
	 * Get the user's active cart
	 */
	public function cart(): HasOne {
		return $this->hasOne(Cart::class)->where('status', 0);
	}
}

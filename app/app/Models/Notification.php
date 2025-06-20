<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	/**
	 * Property: The attributes that are mass assignable
	 */
	protected $fillable = [
		'text',
	];


	/**
	 * Accessor: Convert the 'text' attribute to HTML format
	 */
	protected function text(): Attribute {
		return Attribute::make(
			get: fn(string $value) => nl2br($value),
		);
	}

	/**
	 * Accessor: Format the 'date' attribute to 'Y-m-d'
	 */
	protected function date(): Attribute {
		return Attribute::make(
			get: fn() => date('Y-m-d', strtotime($this->time)),
		);
	}
}

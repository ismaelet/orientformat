<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model {

	/**
	 * Mutate the answers attribute to be an array.
	 * 
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function answers(): Attribute {
		return Attribute::make(
			get: fn(string $value): array => explode(',', $value)
		);
	}
}

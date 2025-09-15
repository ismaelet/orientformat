<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportCategory extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'name',
		'sort',
		'slug',
	];

	/**
	 * Relationship: The topics that belong to the category
	 */
	public function topics(): HasMany {
		return $this->hasMany(SupportTopic::class, 'categoryId');
	}
}

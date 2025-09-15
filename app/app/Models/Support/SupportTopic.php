<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTopic extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'categoryId',
		'name',
		'sort',
		'text',
	];

	/**
	 * Relationship: The category the topic belongs to
	 */
	public function category(): BelongsTo {
		return $this->belongsTo(SupportCategory::class, 'categoryId');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReviewQuestion extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'slug',
        'areaId',
        'reviewIds',
        'text',
        'type',
    ];

    /**
     * Relationship: The reviews this question belongs to
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Review::class, 'review_review_question');
    }

    /**
     * Get the options for the question
     */
    public function options(): array
    {
        return explode(',', $this->rows);
    }

    public function option(int $index): ?string
    {
        $options = $this->options();

        return $options[$index] ?? null;
    }

    /**
     * Get the columns for the question
     */
    public function columns(): array
    {
        return explode(',', $this->gridHeader);
    }

    /**
     * Get the options for the question
     */
    public function optionCount(): int
    {
        if ($this->type == 'list' && $this->multiple) {
            return count($this->options());
        }

        if ($this->type == 'grid' && count($this->options())) {
            return $this->grouppedBy == 'rows' ? count($this->options()) : count($this->columns());
        }

        return 1;
    }
}

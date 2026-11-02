<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Property: The attributes that are mass assignable
     */
    protected $fillable = [
        'text',
        'created_at',
    ];

    /**
     * Attribute: Get a short snippet of the 'text' attribute
     */
    protected function snippet(): Attribute
    {
        return Attribute::make(
            get: fn () => '"'.substr($this->text, 0, 50).'..."',
        );
    }

    /**
     * Attribute: Convert the 'text' attribute to HTML format
     */
    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => nl2br($value),
        );
    }

    /**
     * Attribute: Format the 'date' attribute to 'Y-m-d'
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn () => date('Y-m-d', strtotime($this->created_at)),
        );
    }

    /**
     * Whether the notification was posted since the beginning of the year
     */
    public function recent(): bool
    {
        return $this->created_at >= now()->startOfYear();
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\HasSafeActiveScope;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasSafeActiveScope;

    protected $fillable = [
        'name', 'city', 'photo', 'content',
        'package_name', 'year', 'rating', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating'    => 'integer',
    ];

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        return strtoupper(implode('', array_map(fn($w) => $w[0], array_slice($words, 0, 2))));
    }
}
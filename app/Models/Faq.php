<?php

namespace App\Models;

use App\Models\Concerns\HasSafeActiveScope;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasSafeActiveScope;

    protected $fillable = [
        'question', 'answer', 'category', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
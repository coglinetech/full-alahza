<?php

namespace App\Models;

use App\Models\Concerns\HasSafeActiveScope;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasSafeActiveScope;

    protected $fillable = [
        'image_path', 'caption', 'category', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
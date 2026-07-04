<?php

namespace App\Models;

use App\Models\Concerns\HasSafeActiveScope;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasSafeActiveScope;

    protected $fillable = [
        'title', 'subtitle', 'image_path',
        'link_url', 'link_label',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}

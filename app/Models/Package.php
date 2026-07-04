<?php

namespace App\Models;

use App\Models\Concerns\HasSafeActiveScope;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasSafeActiveScope;

    public const CATEGORY_UMROH_REGULER = 'umroh_reguler';
    public const CATEGORY_UMROH_PLUS = 'umroh_plus';

    protected $fillable = [
        'name', 'slug', 'category', 'duration',
        'price_start', 'currency', 'highlights',
        'description', 'destination', 'is_active', 'sort_order',
        'image_path',
    ];

    protected $casts = [
        'highlights'  => 'array',
        'is_active'   => 'boolean',
        'price_start' => 'integer',
    ];

    public function getFormattedPriceAttribute(): string
{
    return 'Rp ' . number_format((float) $this->price_start, 0, ',', '.');
}

    public static function categories(): array
    {
        return [
            self::CATEGORY_UMROH_REGULER,
            self::CATEGORY_UMROH_PLUS,
        ];
    }

    public static function categoryLabels(): array
    {
        return [
            self::CATEGORY_UMROH_REGULER => 'Umroh Reguler',
            self::CATEGORY_UMROH_PLUS    => 'Umroh Plus',
        ];
    }

    public static function categoryIcons(): array
    {
        return [
            self::CATEGORY_UMROH_REGULER => '🕌',
            self::CATEGORY_UMROH_PLUS    => '✈️',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::categoryLabels()[$this->category] ?? 'Paket';
    }

    public function getCategoryIconAttribute(): string
    {
        return self::categoryIcons()[$this->category] ?? '🕌';
    }
}
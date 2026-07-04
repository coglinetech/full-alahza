<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * SiteSetting — model sederhana untuk menyimpan pengaturan website (key-value)
 *
 * Migration yang perlu dibuat:
 *
 * Schema::create('site_settings', function (Blueprint $table) {
 *     $table->id();
 *     $table->string('key')->unique();
 *     $table->text('value')->nullable();
 *     $table->timestamps();
 * });
 */
class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil nilai setting berdasarkan key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Simpan atau update nilai setting.
     */
    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
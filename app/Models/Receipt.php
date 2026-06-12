<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'payer_name',
        'amount_text',
        'description',
        'package_price',
        'receipt_date',
        'admin_name',
    ];

    protected $casts = [
        'receipt_date' => 'date',
    ];

    public function getDisplayReceiptNumberAttribute(): string
    {
        $value = $this->receipt_number ?? '';

        if (preg_match('/^\[Nomor\s*0*([0-9]+)\]$/', $value, $matches)) {
            return sprintf('%03d', (int) $matches[1]);
        }

        if (preg_match('/^[0-9]+$/', $value)) {
            return sprintf('%03d', (int) $value);
        }

        return $value;
    }
}

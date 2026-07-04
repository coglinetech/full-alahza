<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    protected $fillable = [
        'package_id', 'departure_date', 'return_date',
        'quota', 'booked', 'status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}

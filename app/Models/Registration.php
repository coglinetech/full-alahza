<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'reg_number', 'user_id', 'package_id', 'departure_id',
        'full_name', 'nik', 'birth_date', 'birth_place', 'gender',
        'passport_number', 'passport_expiry', 'phone',
        'emergency_contact_name', 'emergency_contact_phone',
        'mahram_name', 'mahram_relation', 'room_type', 'notes', 'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'passport_expiry' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function departure()
    {
        return $this->belongsTo(Departure::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

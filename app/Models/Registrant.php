<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_option', 'name', 'passport_no', 'passport_issued_date', 'passport_issued_place', 'passport_expiry_date',
        'birth_place', 'birth_date', 'gender', 'address', 'job', 'phone', 'emergency_contacts',
        'mahram_name', 'mahram_relation', 'umrah_experience', 'photo_path', 'documents'
    ];

    protected $casts = [
        'emergency_contacts' => 'array',
        'documents' => 'array',
        'passport_issued_date' => 'date',
        'passport_expiry_date' => 'date',
        'birth_date' => 'date',
    ];
}

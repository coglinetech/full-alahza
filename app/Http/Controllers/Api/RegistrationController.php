<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::where('user_id', $request->user()->id)
            ->with(['package', 'departure'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required',
            'departure_id' => 'required',
            'full_name' => 'required|string',
            'nik' => 'required|string',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'gender' => 'required|in:L,P',
            'passport_number' => 'required|string',
            'passport_expiry' => 'required|date',
            'phone' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'room_type' => 'required|in:quad,triple,double',
        ]);

        // Generate reg number
        $year = date('Y');
        $count = Registration::whereYear('created_at', $year)->count() + 1;
        $regNumber = 'ALZ-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $registration = Registration::create([
            'reg_number' => $regNumber,
            'user_id' => $request->user()->id,
            'package_id' => $request->package_id,
            'departure_id' => $request->departure_id,
            'full_name' => $request->full_name,
            'nik' => $request->nik,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'passport_number' => $request->passport_number,
            'passport_expiry' => $request->passport_expiry,
            'phone' => $request->phone,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'mahram_name' => $request->mahram_name,
            'mahram_relation' => $request->mahram_relation,
            'room_type' => $request->room_type,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data' => $registration->load(['package', 'departure']),
            'message' => 'Pendaftaran berhasil!'
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $registration = Registration::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['package', 'departure', 'payments'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $registration
        ]);
    }
}
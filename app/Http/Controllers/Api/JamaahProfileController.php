<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JamaahProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $registrant = Registrant::where('user_id', $user->id)->first();

        if (!$registrant) {
            // First time, return empty data with 0%
            return response()->json([
                'success' => true,
                'data' => [
                    'verification_status' => 'incomplete',
                    'completion_percentage' => 0,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }

        $data = $registrant->toArray();

        // Format dates correctly as Y-m-d instead of ISO 8601
        $dateFields = ['birth_date', 'passport_issued_date', 'passport_start_date', 'passport_expiry_date'];
        foreach ($dateFields as $df) {
            if (!empty($registrant->$df)) {
                $data[$df] = \Carbon\Carbon::parse($registrant->$df)->format('Y-m-d');
            }
        }

        // Calculate completeness
        $requiredFields = [
            'name', 'phone', 'birth_place', 'birth_date', 'gender',
            'address', 'job', 'umrah_experience', 'photo_path'
        ];

        $filled = 0;
        foreach ($requiredFields as $field) {
            if (!empty($registrant->$field)) {
                $filled++;
            }
        }
        
        // emergency contacts is JSON, check if it has valid array entries
        $ec = $registrant->emergency_contacts;
        if (is_array($ec) && count($ec) > 0) {
            // Assume the first one is the main emergency contact
            $data['emergency_contact_name'] = $ec[0]['name'] ?? null;
            $data['emergency_contact_phone'] = $ec[0]['phone'] ?? null;
            $data['emergency_contact_relation'] = $ec[0]['relation'] ?? null;
            if (!empty($ec[0]['name'])) {
                $filled++;
            }
        }
        
        $totalFields = count($requiredFields) + 1; // +1 for emergency_contacts
        $pct = round(($filled / $totalFields) * 100);

        $data['verification_status'] = $pct == 100 ? 'verified' : 'incomplete'; // Simplified logic
        $data['completion_percentage'] = $pct;
        
        if ($registrant->photo_path) {
             $data['ktp_image_url'] = url('storage/' . $registrant->photo_path);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'job' => 'nullable|string|max:255',
            'umrah_experience' => 'nullable|string|max:50',
            'passport_no' => 'nullable|string|max:255',
            'passport_name' => 'nullable|string|max:255',
            'passport_issued_place' => 'nullable|string|max:255',
            'passport_issued_date' => 'nullable|date',
            'passport_start_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date',
            'mahram_name' => 'nullable|string|max:255',
            'mahram_relation' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'emergency_contact_relation' => 'nullable|string',
            'ktp_image' => 'nullable|image|max:2048',
        ]);

        $registrant = Registrant::firstOrNew(['user_id' => $user->id]);

        $registrant->name = $data['name'];
        $registrant->email = $data['email'] ?? $user->email;
        $registrant->phone = $data['phone'] ?? null;
        $registrant->birth_place = $data['birth_place'] ?? null;
        $registrant->birth_date = $data['birth_date'] ?? null;
        $registrant->gender = $data['gender'] ?? null;
        $registrant->address = $data['address'] ?? null;
        $registrant->job = $data['job'] ?? null;
        $registrant->umrah_experience = $data['umrah_experience'] ?? null;
        $registrant->passport_no = $data['passport_no'] ?? null;
        
        // Note: Admin form has 'passport_issued_place', 'passport_issued_date'
        // If passport_name is sent by mobile, we can put it inside documents json or just ignore since Admin doesnt have it explicitly as 'passport_name', admin uses 'name' on passport as 'name' generally. Let's ignore passport_name or save to documents.
        $documents = is_array($registrant->documents) ? $registrant->documents : [];
        if (!empty($data['passport_name'])) {
             $documents['passport_name'] = $data['passport_name'];
        }
        $registrant->documents = $documents;

        $registrant->passport_issued_place = $data['passport_issued_place'] ?? null;
        $registrant->passport_issued_date = $data['passport_issued_date'] ?? null;
        $registrant->passport_start_date = $data['passport_start_date'] ?? null;
        $registrant->passport_expiry_date = $data['passport_expiry_date'] ?? null;
        
        $registrant->mahram_name = $data['mahram_name'] ?? null;
        $registrant->mahram_relation = $data['mahram_relation'] ?? null;

        if (!empty($data['emergency_contact_name'])) {
             $registrant->emergency_contacts = [[
                 'name' => $data['emergency_contact_name'],
                 'phone' => $data['emergency_contact_phone'] ?? '',
                 'relation' => $data['emergency_contact_relation'] ?? '',
             ]];
        }

        if ($request->hasFile('ktp_image')) {
            $path = $request->file('ktp_image')->store('registrants', 'public');
            $registrant->photo_path = $path;
        }

        $registrant->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $registrant
        ]);
    }
}

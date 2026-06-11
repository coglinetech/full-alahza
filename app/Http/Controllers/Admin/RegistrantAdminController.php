<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrantAdminController extends Controller
{
    public function index()
    {
        $items = Registrant::latest()->paginate(20);
        return view('admin.registrants.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.registrants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'package_option' => 'nullable|string',
            'name' => 'required|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'passport_issued_date' => 'nullable|date',
            'passport_issued_place' => 'nullable|string|max:255',
            'passport_expiry_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'job' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'emergency_contacts' => 'nullable',
            'mahram_name' => 'nullable|string|max:255',
            'mahram_relation' => 'nullable|string|max:100',
            'umrah_experience' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('registrants', 'public');
            $data['photo_path'] = $path;
        }

        // Handle emergency_contacts as array
        if ($request->has('emergency_contacts')) {
            $ec = $request->input('emergency_contacts');
            if (is_string($ec)) {
                // Try to decode JSON
                $decoded = json_decode($ec, true);
                $data['emergency_contacts'] = $decoded ?: [$ec];
            } else {
                $data['emergency_contacts'] = is_array($ec) ? $ec : [$ec];
            }
        }

        $registrant = Registrant::create($data);

        return redirect()->route('admin.registrants.index')->with('success', 'Data pendaftar berhasil disimpan.');
    }

    public function preview(Request $request)
    {
        // Preview from unsaved form data (POST)
        $data = $request->all();
        
        // Handle emergency_contacts if it's JSON string
        if (isset($data['emergency_contacts']) && is_string($data['emergency_contacts'])) {
            $decoded = json_decode($data['emergency_contacts'], true);
            $data['emergency_contacts'] = $decoded ?: [];
        }
        
        return view('admin.registrants.preview', ['data' => $data]);
    }

    public function show(Registrant $registrant)
    {
        return view('admin.registrants.preview', ['data' => $registrant]);
    }
}

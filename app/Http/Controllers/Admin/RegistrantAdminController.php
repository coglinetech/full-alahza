<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrantAdminController extends Controller
{
    public function index()
    {
        $items = Registrant::latest()->paginate(20);
        $items = Registrant::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.registrants.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.registrants.create');
    }

    public function edit(Registrant $registrant)
    {
        return view('admin.registrants.edit', ['registrant' => $registrant]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
<<<<<<< HEAD
            'email' => 'nullable|email',
=======
>>>>>>> projek_kedua/master
            'package_option' => 'nullable|string',
            'name' => 'required|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'passport_issued_date' => 'nullable|date',
            'passport_issued_place' => 'nullable|string|max:255',
            'passport_start_date' => 'nullable|date',
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
<<<<<<< HEAD
            'photo' => 'nullable|image|max:2048',
=======
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
>>>>>>> projek_kedua/master
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
                $data['emergency_contacts'] = is_array($decoded) ? $decoded : [];
            } else {
                $data['emergency_contacts'] = is_array($ec) ? $ec : [];
            }
        }

        $registrant = Registrant::create($data);

        return redirect()->route('admin.registrants.index')->with('success', 'Data pendaftar berhasil disimpan.');
    }

    public function update(Request $request, Registrant $registrant)
    {
<<<<<<< HEAD
        $emailRule = 'nullable|email';
        if ($registrant->user_id) {
            $emailRule = 'nullable|email|unique:users,email,' . $registrant->user_id;
        }

        $data = $request->validate([
            'email' => $emailRule,
=======
        $data = $request->validate([
>>>>>>> projek_kedua/master
            'package_option' => 'nullable|string',
            'name' => 'required|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'passport_issued_date' => 'nullable|date',
            'passport_issued_place' => 'nullable|string|max:255',
            'passport_start_date' => 'nullable|date',
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
<<<<<<< HEAD
            'photo' => 'nullable|image|max:2048',
=======
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
>>>>>>> projek_kedua/master
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($registrant->photo_path) {
                Storage::disk('public')->delete($registrant->photo_path);
            }
            $path = $request->file('photo')->store('registrants', 'public');
            $data['photo_path'] = $path;
        }

        // Handle emergency_contacts as array
        if ($request->has('emergency_contacts')) {
            $ec = $request->input('emergency_contacts');
            if (is_string($ec)) {
                // Try to decode JSON
                $decoded = json_decode($ec, true);
                $data['emergency_contacts'] = is_array($decoded) ? $decoded : [];
            } else {
                $data['emergency_contacts'] = is_array($ec) ? $ec : [];
            }
        }

        $registrant->update($data);

<<<<<<< HEAD
        if ($registrant->user_id && isset($data['email'])) {
            $user = User::find($registrant->user_id);
            if ($user && $user->email !== $data['email']) {
                $user->update(['email' => $data['email']]);
            }
        }

=======
>>>>>>> projek_kedua/master
        return redirect()->route('admin.registrants.index')->with('success', 'Data pendaftar berhasil diupdate.');
    }

    public function preview(Request $request)
    {
        // Preview from unsaved form data (POST)
        $data = $request->all();
        
        // Handle emergency_contacts if it's JSON string
        if (isset($data['emergency_contacts'])) {
            if (is_string($data['emergency_contacts'])) {
                $decoded = json_decode($data['emergency_contacts'], true);
                $data['emergency_contacts'] = is_array($decoded) ? $decoded : [];
            } else if (is_array($data['emergency_contacts'])) {
                // Already an array, keep as is
            } else {
                $data['emergency_contacts'] = [];
            }
        } else {
            $data['emergency_contacts'] = [];
        }
        
        return view('admin.registrants.preview', ['data' => $data]);
    }

    public function show(Registrant $registrant)
    {
        // Convert model to array for consistent handling
        $data = $registrant->toArray();
        if (!isset($data['emergency_contacts']) || !is_array($data['emergency_contacts'])) {
            $data['emergency_contacts'] = [];
        }
        return view('admin.registrants.preview', ['data' => $data]);
    }

<<<<<<< HEAD
    public function account(Registrant $registrant)
    {
        return view('admin.registrants.account', compact('registrant'));
    }

    public function storeAccount(Request $request, Registrant $registrant)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        if (!$registrant->email) {
            return back()->withErrors(['email' => 'Jamaah belum memiliki email. Silakan edit data jamaah terlebih dahulu.']);
        }

        if (User::where('email', $registrant->email)->exists()) {
            return back()->withErrors(['email' => 'Email ini sudah terdaftar sebagai pengguna.']);
        }

        $user = User::create([
            'name' => $registrant->name,
            'email' => $registrant->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        $registrant->update(['user_id' => $user->id]);

        return back()->with('success', 'Akun mobile berhasil dibuat.');
    }

    public function updateAccount(Request $request, Registrant $registrant)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        if ($registrant->user_id) {
            $user = User::find($registrant->user_id);
            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        return back()->with('success', 'Password akun berhasil diubah.');
    }

    public function destroyAccount(Registrant $registrant)
    {
        if ($registrant->user_id) {
            $user = User::find($registrant->user_id);
            if ($user) {
                $user->delete();
            }
            $registrant->update(['user_id' => null]);
        }

        return back()->with('success', 'Akun mobile berhasil dihapus.');
    }

=======
>>>>>>> projek_kedua/master
    public function destroy(Registrant $registrant)
    {
        if ($registrant->photo_path) {
            Storage::disk('public')->delete($registrant->photo_path);
        }

        $registrant->delete();

        return redirect()->route('admin.registrants.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}

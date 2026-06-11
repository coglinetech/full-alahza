<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialAdminController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'city'         => 'nullable|string|max:100',
            'package_name' => 'nullable|string|max:255',
            'year'         => 'nullable|string|max:10',
            'rating'       => 'required|integer|min:1|max:5',
            'content'      => 'required|string',
            'is_active'    => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni dari "' . $data['name'] . '" berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'city'         => 'nullable|string|max:100',
            'package_name' => 'nullable|string|max:255',
            'year'         => 'nullable|string|max:10',
            'rating'       => 'required|integer|min:1|max:5',
            'content'      => 'required|string',
            'is_active'    => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function toggle(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        return back()->with('success', 'Status testimoni diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni dari "' . $name . '" berhasil dihapus.');
    }
}
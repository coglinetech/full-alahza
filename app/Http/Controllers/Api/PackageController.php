<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Departure;
use App\Models\Testimonial;
use App\Models\Faq;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    public function departures($packageId)
    {
        $departures = Departure::where('package_id', $packageId)
            ->where('status', 'open')
            ->orderBy('departure_date')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $departures
        ]);
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function faqs()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }
}
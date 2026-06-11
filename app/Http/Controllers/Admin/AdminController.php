<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\GalleryImage;
use App\Models\Faq;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'packages'     => Package::count(),
            'testimonials' => Testimonial::count(),
            'gallery'      => GalleryImage::count(),
            'faqs'         => Faq::count(),
        ];
        $recentPackages     = Package::latest()->take(5)->get();
        $recentTestimonials = Testimonial::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPackages', 'recentTestimonials'));
    }
}
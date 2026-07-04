<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        $packages     = Package::active()->ordered()->get();
        $testimonials = Testimonial::active()->orderByDesc('created_at')->take(6)->get();
        $faqs         = Faq::active()->ordered()->get();

        $gallery = GalleryImage::active()
            ->ordered()
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->take(24)
            ->get()
            ->filter(fn (GalleryImage $image) => Storage::disk('public')->exists($image->image_path))
            ->take(12)
            ->values();

        $banners = Banner::active()->ordered('asc', 'sort_order')->get();

        $aboutImage = SiteSetting::getValue('about_image_path');
        if (!empty($aboutImage) && !Storage::disk('public')->exists($aboutImage)) {
            $aboutImage = null;
        }

        return view('home', compact(
            'packages',
            'testimonials',
            'faqs',
            'gallery',
            'aboutImage',
            'banners'
        ));
    }

    public function packageDetail(string $slug)
    {
        $package  = Package::active()->where('slug', $slug)->firstOrFail();

        // Paket lain untuk navigasi/rekomendasi (exclude current)
        $others   = Package::active()
                           ->where('id', '!=', $package->id)
                   ->ordered()
                           ->get();

        return view('package-detail', compact('package', 'others'));
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::active()
            ->ordered()
            ->get()
            ->map(function ($banner) {
                return [
                    'id'         => $banner->id,
                    'title'      => $banner->title,
                    'subtitle'   => $banner->subtitle,
                    'image_url'  => asset('storage/' . $banner->image_path),
                    'link_url'   => $banner->link_url,
                    'link_label' => $banner->link_label,
                    'sort_order' => $banner->sort_order,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $banners,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Halaman utama — list semua paket (dipakai di HomeController juga)
     */
    public function index()
    {
        $packages = Package::ordered()->get();
        return view('packages.index', compact('packages'));
    }

    /**
     * Halaman detail paket berdasarkan slug
     */
    public function show($slug)
    {
        $package = Package::where('slug', $slug)->firstOrFail();
        return view('packages.show', compact('package'));
    }
}
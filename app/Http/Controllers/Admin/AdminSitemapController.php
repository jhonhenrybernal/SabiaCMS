<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class AdminSitemapController extends Controller
{
    /**
     * Panel admin del sitemap
     * - Muestra la URL pública /sitemap.xml
     * - Permite invalidar caché para regeneración inmediata
     */
    public function edit()
    {
        return Inertia::render('admin/Sitemap/Edit', [
            'publicUrl' => url('/sitemap.xml'),
            'isCached' => Cache::has(SitemapController::cacheKey()),
        ]);
    }

    public function regenerate()
    {
        Cache::forget(SitemapController::cacheKey());

        return back()->with('success', 'Sitemap regenerado (caché limpiada).');
    }
}

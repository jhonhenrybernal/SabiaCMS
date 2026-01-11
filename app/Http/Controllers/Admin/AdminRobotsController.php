<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminRobotsController extends Controller
{
    public function edit()
    {
        $default = "User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml') . "\n";

        return Inertia::render('admin/Robots/Edit', [
            'robots' => Settings::get('robots_txt', $default),
            'publicUrl' => url('/robots.txt'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'robots' => ['required', 'string'],
        ]);

        Settings::put('robots_txt', $data['robots']);

        return back()->with('success', 'Robots actualizado.');
    }

    public function reset()
    {
        $default = "User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml') . "\n";
        Settings::put('robots_txt', $default);

        return back()->with('success', 'Robots restaurado a valores por defecto.');
    }
}

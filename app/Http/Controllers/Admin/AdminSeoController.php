<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminSeoController extends Controller
{
    public function edit()
    {
        return Inertia::render('admin/Seo/Edit', [
            'seo' => [
                'site_name' => Settings::get('seo_site_name', config('app.name')),
                'title' => Settings::get('seo_title', ''),
                'description' => Settings::get('seo_description', ''),
                'keywords' => Settings::get('seo_keywords', ''),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:500'],
        ]);

        Settings::put('seo_site_name', $data['site_name']);
        Settings::put('seo_title', $data['title'] ?? '');
        Settings::put('seo_description', $data['description'] ?? '');
        Settings::put('seo_keywords', $data['keywords'] ?? '');

        return back()->with('success', 'SEO guardado.');
    }
}

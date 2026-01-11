<?php

namespace App\Http\Controllers;

use App\Support\Settings;
use Illuminate\Http\Response;

class RobotsController
{
    public function show(): Response
    {
        $default = "User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml') . "\n";

        $content = Settings::get('robots_txt', $default);

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}

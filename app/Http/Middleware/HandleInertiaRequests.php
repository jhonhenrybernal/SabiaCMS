<?php

namespace App\Http\Middleware;

use App\Models\AdminMenuItem;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Support\Settings;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'adsense' => [
                'enabled' => Settings::get('adsense_enabled', '0') === '1',
                'client' => Settings::get('adsense_client', ''),
                'slotDefault' => Settings::get('adsense_slot_default', ''),
            ],
            'seo' => [
                'site_name' => Settings::get('seo_site_name', config('app.name')),
                'title' => Settings::get('seo_title', ''),
                'description' => Settings::get('seo_description', ''),
                'keywords' => Settings::get('seo_keywords', ''),

                'robots' => Settings::get('seo_robots', 'index,follow'),
                'canonical_base' => Settings::get('seo_canonical_base', ''),
                'og_image' => Settings::get('seo_og_image', ''),
                'google_site_verification' => Settings::get('seo_google_site_verification', ''),
                'bing_site_verification' => Settings::get('seo_bing_site_verification', ''),
                'schema_enabled' => Settings::get('seo_schema_enabled', '1') === '1',
                'hreflang_enabled' => Settings::get('seo_hreflang_enabled', '1') === '1',
            ],
        ];
    }
}

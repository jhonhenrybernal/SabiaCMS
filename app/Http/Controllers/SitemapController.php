<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController
{
    /**
     * Sitemap público /sitemap.xml
     *
     * Dinámico + caché:
     * - Genera el XML a partir de las URLs del sitio (por ahora: home + idiomas).
     * - Se cachea para performance (por defecto 6 horas).
     * - Se puede invalidar desde el panel admin con un botón "Regenerar".
     */
    public function show(): Response
    {
        $xml = Cache::remember($this->cacheKey(), now()->addHours(6), function () {
            $urls = $this->buildUrls();

            return view('seo.sitemap', [
                'urls' => $urls,
            ])->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public static function cacheKey(): string
    {
        return 'seo:sitemap.xml';
    }

    private function buildUrls(): array
    {
        // ✅ Mínimo recomendado: home + 4 idiomas (aunque estén "vacíos")
        $baseUrls = [
            [
                'loc' => url('/'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => url('/es'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => url('/en'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => url('/fr'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => url('/it'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
        ];

        // Aquí luego puedes sumar URLs desde BD (mensajes/páginas, etc.)
        return $baseUrls;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAdSenseController extends Controller
{
    /**
     * Panel administrativo para Google AdSense.
     *
     * Permite:
     * - Activar/desactivar AdSense globalmente para todo el sitio.
     * - Configurar el Publisher ID (ca-pub-xxxx).
     * - Configurar un slot por defecto.
     * - Mostrar instrucciones para agregar anuncios en nuevas páginas (Vue/Inertia).
     */
    public function edit()
    {
        return Inertia::render('admin/AdSense/Edit', [
            'adsense' => [
                'enabled' => Settings::get('adsense_enabled', '0') === '1',
                'client' => Settings::get('adsense_client', ''),
                'slot_default' => Settings::get('adsense_slot_default', ''),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'enabled' => ['required', 'boolean'],
            'client' => ['nullable', 'string', 'max:64'],          // ca-pub-...
            'slot_default' => ['nullable', 'string', 'max:32'],     // numérico como string
        ]);

        Settings::put('adsense_enabled', $data['enabled'] ? '1' : '0');
        Settings::put('adsense_client', trim((string)($data['client'] ?? '')));
        Settings::put('adsense_slot_default', trim((string)($data['slot_default'] ?? '')));

        return back()->with('success', 'Configuración de AdSense guardada.');
    }
}

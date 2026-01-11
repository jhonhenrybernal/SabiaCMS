<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Opcional: ajustar watchers si quieres
        // Telescope::night();
    }

    /**
     * Controla quién puede ver Telescope.
     * Solo admins (is_admin = 1).
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            return (bool) ($user->is_admin ?? false);
        });
    }
}

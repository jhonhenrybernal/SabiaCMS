<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sabiduriaviva.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin12345'),
                'is_admin' => true,
            ]
        );

        $this->command->info('✅ Usuario admin creado: admin@sabiduriaviva.com / admin12345');
    }
}

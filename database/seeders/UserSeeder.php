<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = User::factory()->create([
            'name' => ! empty(config('app.root_name')) ? config('app.root_name') : 'Administrador',
            'email' => ! empty(config('app.root_email')) ? config('app.root_email') : 'admin@gmail.com',
            'password' => Hash::make(! empty(config('app.root_password'))) ? config('app.root_password') : '12345678',
            'email_verified_at' => true,
            'is_root' => true,
        ]);

        if ($root->email != 'admin@gmail.com') {
            $admin = User::factory()->create([
                'name' => 'Administrador',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => true,
            ]);

            $this->command->info("Usuario root: '{$root->email}'");
            if ($admin) {
                $this->command->info("Usuario admin: '{$admin->email}'");
                $this->command->info("Clave admin: '12345678'");
            }
        }
    }
}

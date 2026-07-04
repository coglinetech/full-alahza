<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('ADMIN_SEED_NAME', 'Administrator Al-Ahza');
        $email = env('ADMIN_SEED_EMAIL', 'admin@alahza.test');
        $password = env('ADMIN_SEED_PASSWORD', 'admin12345');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->fill([
                'name' => $name,
                'role' => 'admin',
                'email_verified_at' => $user->email_verified_at ?? now(),
                'password' => Hash::make($password),
            ]);
            $user->save();

            return;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make($password),
        ]);
    }
}
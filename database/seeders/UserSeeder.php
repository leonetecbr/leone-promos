<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@' . config('app.domain'),
            'email_verified_at' => time(),
            'password' => password_hash(config('app.password'), PASSWORD_DEFAULT),
            'remember_token' => bin2hex(openssl_random_pseudo_bytes(32))
        ]);
    }
}

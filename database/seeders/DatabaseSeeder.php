<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Albert Devada',
            'email' => 'testing@alien66.tech',
            'password' => Hash::make('Yp291215!@#'),
            'status' => 'active',
            'avatars' => 'default.png',
            'phone' => '08123454994',
        ]);

        $keys = $user->generateApiKey();

        $this->command->info('Dummy User created with email: ' . $user->email);
        $this->command->info('Public Key: ' . $keys['public_key']);
        $this->command->info('Sanctum Token: ' . $keys['sanctum_token']);
        $this->command->info('Remember to keep the Sanctum Token secret!');
    }
}

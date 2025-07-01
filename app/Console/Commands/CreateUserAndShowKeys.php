<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserAndShowKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and immediately display their API keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = Str::random(16);

        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return Command::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => 'active', // Default status
            'avatars' => 'default.png', // Default avatar
        ]);

        $keys = $user->generateApiKey();

        $this->info('✅ User successfully created!');
        $this->line('---------------------------------');
        $this->line('Email    : ' . $user->email);
        $this->line('Password : ' . $password);
        $this->line('Public Key : ' . $keys['public_key']);
        $this->line('Sanctum Token: ' . $keys['sanctum_token']);
        $this->warn('🔒 Remember to copy the Password and Sanctum Token now. You will not be able to see them again.');

        return Command::SUCCESS;
    }
}
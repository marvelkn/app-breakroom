<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'role_id' => 1,
                'photo' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Test User',
                'email' => 'user@gmail.com',
                'role_id' => 2,
                'photo' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

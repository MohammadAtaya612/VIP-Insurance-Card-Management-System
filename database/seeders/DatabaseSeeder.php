<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@vip.local',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'موظف',
            'email' => 'employee@vip.local',
            'password' => Hash::make('password'),
            'role' => UserRole::Employee,
            'is_active' => true,
        ]);
    }
}

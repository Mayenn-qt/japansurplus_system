<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Owner
        User::create([
            'name' => 'Owner',
            'email' => 'owner@ohaiyo.com',
            'password' => Hash::make('admin_ohaiyo'),
            'role' => 'owner',
            'branch_id' => null,
        ]);

        // Main Branch Staff
        User::create([
            'name' => 'Main Branch Staff',
            'email' => 'main@ohaiyo.com',
            'password' => Hash::make('main_ohaiyo'),
            'role' => 'staff',
            'branch_id' => 1,
        ]);

        // Juban Branch Staff
        User::create([
            'name' => 'Juban Branch Staff',
            'email' => 'juban@ohaiyo.com',
            'password' => Hash::make('juban_ohaiyo'),
            'role' => 'staff',
            'branch_id' => 2,
        ]);

        // Gubat Branch Staff
        User::create([
            'name' => 'Gubat Branch Staff',
            'email' => 'gubat@ohaiyo.com',
            'password' => Hash::make('gubat_ohaiyo'),
            'role' => 'staff',
            'branch_id' => 3,
        ]);
    }
}
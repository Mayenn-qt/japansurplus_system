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
            'password' => Hash::make('admin123'),
            'role' => 'owner',
            'branch_id' => null,
        ]);

        // Main Branch Staff
        User::create([
            'name' => 'Main Branch Staff',
            'email' => 'main@ohaiyo.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'branch_id' => 1,
        ]);

        // Bacon Branch Staff
        User::create([
            'name' => 'Bacon Branch Staff',
            'email' => 'bacon@ohaiyo.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'branch_id' => 2,
        ]);

        // Gubat Branch Staff
        User::create([
            'name' => 'Gubat Branch Staff',
            'email' => 'gubat@ohaiyo.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'branch_id' => 3,
        ]);
    }
}
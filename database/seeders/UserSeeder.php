<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Store Owner',
            'email' => 'owner@ohaiyojapan.com',
            'password' => Hash::make('owner_ohaiyojapan'),
            'role' => 'owner',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Main Staff',
            'email' => 'staffmain@ohaiyojapan.com',
            'password' => Hash::make('main_ohaiyojapan'),
            'role' => 'staff',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Juban Staff',
            'email' => 'staffjuban@ohaiyojapan',
            'password' => Hash::make('juban_ohaiyojapan'),
            'role' => 'staff',
            'branch_id' => 2,
        ]);

        User::create([
            'name' => 'Magallanes Staff',
            'email' => 'staffmagallanes@ohaiyojapan',
            'password' => Hash::make('magallanes_ohaiyojapan'),
            'role' => 'staff',
            'branch_id' => 3,
        ]);
    }
}

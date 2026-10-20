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
        User::updateOrCreate(
            ['email' => 'owner@ohaiyojapan.com'],
            [
                'name' => 'Store Owner',
                'password' => Hash::make('owner_ohaiyojapan'),
                'role' => 'owner',
                'branch_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staffmain@ohaiyojapan.com'],
            [
                'name' => 'Main Staff',
                'password' => Hash::make('main_ohaiyojapan'),
                'role' => 'staff',
                'branch_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staffjuban@ohaiyojapan.com'],
            [
                'name' => 'Juban Staff',
                'password' => Hash::make('juban_ohaiyojapan'),
                'role' => 'staff',
                'branch_id' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staffmasbate@ohaiyojapan.com'],
            [
                'name' => 'Masbate Staff',
                'password' => Hash::make('masbate_ohaiyojapan'),
                'role' => 'staff',
                'branch_id' => 3,
            ]
        );
    }
}
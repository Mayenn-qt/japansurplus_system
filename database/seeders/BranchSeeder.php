<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'branch_name' => 'Main Branch',
            'address' => 'Pangpang',
            'email' => 'main@ohaiyojapan.com',
            
        ]);

        Branch::create([
            'branch_name' => 'Juban Branch',
            'address' => 'Juban',
            'email' => 'juban@ohaiyojapan.com',
        ]);

        Branch::create([
            'branch_name' => 'Magallanes Branch',
            'address' => 'Magallanes',
            'email' => 'magallanes@ohaiyojapan.com',
        ]);
    }
}

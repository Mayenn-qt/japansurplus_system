<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::insert([
            [
                'branch_name' => 'Main Branch',
                'address' => 'Sorsogon City',
            ],
            [
                'branch_name' => 'Bacon Branch',
                'address' => 'Bacon, Sorsogon City',
            ],
            [
                'branch_name' => 'Gubat Branch',
                'address' => 'Gubat, Sorsogon',
            ],
        ]);
    }
}
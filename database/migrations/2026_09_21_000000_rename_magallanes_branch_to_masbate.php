<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('branches')
            ->where('id', 3)
            ->update([
                'branch_name' => 'Masbate Branch',
                'address' => 'Masbate',
                'email' => 'masbate@ohaiyojapan.com',
            ]);

        if (Schema::hasTable('users')) {
            DB::table('users')
                ->where('branch_id', 3)
                ->where('email', 'staffmagallanes@ohaiyojapan.com')
                ->update([
                    'name' => 'Masbate Staff',
                    'email' => 'staffmasbate@ohaiyojapan.com',
                    'password' => Hash::make('masbate_ohaiyojapan'),
                ]);
        }
    }

    public function down(): void
    {
        DB::table('branches')
            ->where('id', 3)
            ->update([
                'branch_name' => 'Magallanes Branch',
                'address' => 'Magallanes',
                'email' => 'magallanes@ohaiyojapan.com',
            ]);

        if (Schema::hasTable('users')) {
            DB::table('users')
                ->where('branch_id', 3)
                ->where('email', 'staffmasbate@ohaiyojapan.com')
                ->update([
                    'name' => 'Magallanes Staff',
                    'email' => 'staffmagallanes@ohaiyojapan.com',
                    'password' => Hash::make('magallanes_ohaiyojapan'),
                ]);
        }
    }
};

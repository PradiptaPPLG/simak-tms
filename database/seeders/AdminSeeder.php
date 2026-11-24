<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['role' => 'admin_tms'],
            [
                'account_id' => 'admin',
                'username' => 'admintms',
                'name' => 'Admin TMS',
                'email' => 'admin@tms.co.id',
                'password' => Hash::make('tmsadmin123'),
                'school_origin' => 'PT. Teknologi Multi Sistem',
                'major' => 'Human Resources & Internship Coordinator',
                'phone_number' => '081234595426',
                'location' => 'Kantor Pusat PT. TMS',
                'profile_hash' => '3672a8ee1e8803d9',
                'must_change_password' => 0,
                'status' => 'aktif',
                'updated_at' => now(),
            ]
        );
    }
}

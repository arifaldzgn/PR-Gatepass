<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'deptList_id' => 1,
                'email' => 'arifaldzgn@gmail.com',
                'name' => 'admin',
                'badge_no' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('admin'),
            ],
            [
                'deptList_id' => 1,
                'email' => 'aryfalblog@gmail.com',
                'name' => 'Andi S',
                'badge_no' => 'hod',
                'role' => 'hod',
                'password' => Hash::make('12345'),
            ],
            [
                'deptList_id' => 1,
                'email' => 'securityetowa@gmail.com',
                'name' => 'security',
                'badge_no' => 'security',
                'role' => 'security',
                'password' => Hash::make('12345'),
            ],
        ]);
    }
}

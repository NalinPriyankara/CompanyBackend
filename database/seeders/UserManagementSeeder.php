<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_managements')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'department' => 'IT',
                'telephone' => '0712345678',
                'address' => 'Colombo',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin@123'),
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Normal',
                'last_name' => 'User',
                'department' => 'HR',
                'telephone' => '0771234567',
                'address' => 'Kandy',
                'email' => 'user@example.com',
                'password' => Hash::make('user@123'),
                'role' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

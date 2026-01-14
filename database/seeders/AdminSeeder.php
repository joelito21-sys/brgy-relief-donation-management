<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a super admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@floodcontrol.com',
            'password' => Hash::make('password'),
            'is_super_admin' => true,
        ]);

        // Create a regular admin
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@floodcontrol.com',
            'password' => Hash::make('password'),
            'is_super_admin' => false,
        ]);
    }
}

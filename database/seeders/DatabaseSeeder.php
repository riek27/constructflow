<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create roles and permissions
        $this->call(RoleSeeder::class);

        // 2. Create a default admin user if none exists
        if (!User::where('email', 'admin@constructflow.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@constructflow.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('Administrator');
        }

        // Optional: create sample users with different roles
        if (!User::where('email', 'commercial@constructflow.com')->exists()) {
            $cm = User::create([
                'name' => 'Commercial Manager',
                'email' => 'commercial@constructflow.com',
                'password' => bcrypt('password'),
            ]);
            $cm->assignRole('Commercial Manager');
        }

        if (!User::where('email', 'pm@constructflow.com')->exists()) {
            $pm = User::create([
                'name' => 'Project Manager',
                'email' => 'pm@constructflow.com',
                'password' => bcrypt('password'),
            ]);
            $pm->assignRole('Project Manager');
        }
    }
}
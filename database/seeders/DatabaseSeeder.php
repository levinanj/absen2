<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Berfungsi untuk mengisi data awal ke database seperti pengaturan default.
     * atau digunakan untuk referensi pengisian data
     * @return void
     */

     public function run()
    {
        // Create roles
        $userRole = Role::create(['name' => 'User']);
        $adminRole = Role::create(['name' => 'Admin']);

        // Create permissions (if needed)
        // $manageUsers = Permission::create(['name' => 'manage users']);

        // Create users with roles
        $users = [
            [
                'name' => 'User',
                'email' => 'user@absen.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nama Guru',
                'email' => 'guru@absen.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nama Admin',
                'email' => 'admin@absen.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            if ($userData['name'] === 'User') {
                $user->assignRole($userRole);
            } elseif ($userData['name'] === 'Nama Admin' || $userData['name'] === 'Nama Guru') {
                $user->assignRole($adminRole);
            }
        }

        $this->call(SettingSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}

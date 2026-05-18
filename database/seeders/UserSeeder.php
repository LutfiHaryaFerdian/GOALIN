<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@goalin.test'],
            [
                'name'     => 'Admin GOALIN',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '081111111111',
            ]
        );

        // Owners
        User::firstOrCreate(
            ['email' => 'owner1@goalin.test'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'owner',
                'phone'    => '082222222222',
            ]
        );

        User::firstOrCreate(
            ['email' => 'owner2@goalin.test'],
            [
                'name'     => 'Sari Dewi',
                'password' => Hash::make('password'),
                'role'     => 'owner',
                'phone'    => '083333333333',
            ]
        );

        // Regular users
        User::firstOrCreate(
            ['email' => 'user1@goalin.test'],
            [
                'name'     => 'Andi Kurniawan',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'phone'    => '084444444444',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user2@goalin.test'],
            [
                'name'     => 'Rina Wijaya',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'phone'    => '085555555555',
            ]
        );
    }
}

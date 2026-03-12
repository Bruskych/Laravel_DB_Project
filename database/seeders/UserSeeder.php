<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Pán Admin',
                'email' => 'admin@ukf.sk',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dávid Držík',
                'email' => 'ddrzik@ukf.sk',
                'password' => Hash::make('456'),
                'role' => 'user',
                'premium_until' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jozef Kapusta',
                'email' => 'jkapusta@ukf.sk',
                'password' => Hash::make('789'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mária Nováková',
                'email' => 'mnovakova@example.com',
                'password' => Hash::make('abc123'),
                'role' => 'user',
                'premium_until' => now()->addDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Peter Horváth',
                'email' => 'phorvath@example.com',
                'password' => Hash::make('xyz789'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maksym Svider',
                'email' => 'msvider@example.com',
                'password' => Hash::make('777'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

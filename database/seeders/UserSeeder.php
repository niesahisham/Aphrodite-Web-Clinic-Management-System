<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User',       'email' => 'admin@test.com',        'role' => 'admin'],
            ['name' => 'Dr. Sarah Lee',    'email' => 'doctor@test.com',       'role' => 'doctor'],
            ['name' => 'Nurse Aida',       'email' => 'nurse@test.com',        'role' => 'nurse'],
            ['name' => 'Receptionist Ali', 'email' => 'receptionist@test.com', 'role' => 'receptionist'],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password123'),
                    'role'     => $data['role'],
                ]
            );
        }
    }
}
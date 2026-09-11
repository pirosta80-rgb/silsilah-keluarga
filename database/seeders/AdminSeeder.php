<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin Utama',
                'username' => 'admin1',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Admin Kedua',
                'username' => 'admin2',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Admin Ketiga',
                'username' => 'admin3',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}

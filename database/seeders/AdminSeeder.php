<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Admin Pertama',
            'email' => 'admin1ubsc@gmail.com',
            'password' => Hash::make('adminsatu'),
        ]);

        Admin::create([
            'nama_lengkap' => 'Admin Kedua',
            'email' => 'admin2ubsc@gmail.com',
            'password' => Hash::make('admindua'),
        ]);
    }
}

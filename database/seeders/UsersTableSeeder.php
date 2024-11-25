<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data untuk Admin
        User::create([
            'name' => 'Admin',
            'email' => 'login@admin.com',
            'password' => Hash::make('admin123'), // Password di-hash
            'roles' => 'admin',
            'aktif' => 1,
        ]);

        // Data untuk Owner
        User::create([
            'name' => 'Muhammad Nabil Rabbani',
            'email' => 'nblrbbni@gmail.com',
            'password' => Hash::make('nabil123'), // Password di-hash
            'roles' => 'owner',
            'aktif' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::insert([
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'Karyawan']
        ]);


        User::factory()->create([
            'id' => 1,
            'role_id' => '1',
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'contact' => '+6283825740343'
        ]);
    }
}

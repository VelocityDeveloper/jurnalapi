<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'      => 'Test User',
            'email'     => 'test@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);
        User::factory()->create([
            'name'      => 'Admin',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        //buat web developer 4
        for ($i = 1; $i <= 4; $i++) {
            User::factory()->create([
                'name'      => 'Web Developer ' . $i,
                'email'     => 'webdeveloper' . $i . '@example.com',
                'password'  => Hash::make('password'),
                'role'      => 'webdeveloper',
            ]);
        }
    }
}

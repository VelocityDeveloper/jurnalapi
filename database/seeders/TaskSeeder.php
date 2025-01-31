<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dapatkan semua user, dengan role webdeveloper
        $users = User::where('role', 'webdeveloper')->get();

        foreach ($users as $user) {
            Task::factory()->count(20)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}

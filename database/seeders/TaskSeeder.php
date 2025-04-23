<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
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

            // Loop untuk membuat task dari 30 hari kebelakang sampai 30 hari kedepan
            for ($i = -90; $i <= 30; $i++) {

                // Hitung tanggal 30 hari kebelakang
                $date = Carbon::today()->addDays($i);

                // Tentukan jumlah task untuk hari tersebut (antara 5 hingga 10 task)
                $taskCount = rand(5, 10);

                // Buat task sebanyak $taskCount untuk hari tersebut
                for ($j = 0; $j < $taskCount; $j++) {

                    // Tentukan durasi task (antara 1 hingga 3 hari)
                    $duration = rand(1, 3);

                    // Tentukan jam mulai secara acak (misalnya antara jam 8 pagi sampai jam 11 pagi)
                    $startDate = (clone $date)->setTime(rand(8, 11), rand(0, 59)); // Start time antara 08:00 sampai 11:59

                    // Tanggal selesai task dengan menambahkan durasi ke start time
                    $endDate = (clone $startDate)->addDays($duration)->setTime(rand(16, 18), rand(0, 59)); // End time antara jam 4 sore sampai 6 sore

                    Task::factory()->create([
                        'user_id'       => $user->id,
                        'start'         => $startDate->toDateTimeString(), // Tanggal dan waktu mulai
                        'end'           => $endDate->toDateTimeString(), // Tanggal dan waktu selesai
                        'created_at'    => $startDate,
                        'updated_at'    => $startDate,
                    ]);
                }
            }
        }
    }
}

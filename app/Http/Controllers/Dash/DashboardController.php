<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function datatable()
    {
        $task = Task::with('user:id,name,avatar')
            ->orderBy('start', 'desc')
            ->paginate(20);

        return response()->json($task);
    }


    public function welcome()
    {

        //get semua user
        $users = User::all();
        //collection user name and avatar
        $users = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'avatar' => $user->avatar_url,
            ];
        });

        // Periode sebelumnya (bulan lalu)
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        // Periode sekarang (bulan ini)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Hitung jumlah task pada periode sebelumnya
        $previousTasks = Task::whereMonth('start', $previousMonth)
            ->whereYear('start', $previousYear)
            ->count();

        // Hitung jumlah task pada periode sekarang
        $currentTasks = Task::whereMonth('start', $currentMonth)
            ->whereYear('start', $currentYear)
            ->count();

        // Hitung kenaikan absolut
        $absoluteIncrease = $currentTasks - $previousTasks;

        // Hitung kenaikan persentase
        if ($previousTasks > 0) {
            $percentageIncrease = ($absoluteIncrease / $previousTasks) * 100;
        } else {
            $percentageIncrease = $currentTasks > 0 ? 100 : 0;
        }
        //bulatkan
        $percentageIncrease = round($percentageIncrease, 2);

        // Hitung jumlah task pada bulan ini
        $tasks = Task::thisMonth()->count();

        return response()->json([
            'total_task' => $tasks,
            'absolute_increase' => $absoluteIncrease,
            'percentage_increase' => $percentageIncrease,
            'users' => $users,
        ]);
    }
    public function count30hari()
    {
        $tasks = Task::where('start', '>=', Carbon::now()->subDays(30))
            ->groupBy('start_date')
            ->selectRaw('DATE(start) as start_date, COUNT(*) as task_count')
            ->orderBy('start_date')
            ->get();

        $labels = $tasks->map(function ($task) {
            return $task->start_date;
        })->toArray();

        $data = $tasks->map(function ($task) {
            return $task->task_count;
        })->toArray();

        return response()->json(
            [
                'labels' => $labels,
                'data' => $data,
            ]
        );
    }

    public function count1year()
    {
        $tasks = Task::whereYear('start', Carbon::now()->year)
            ->groupBy('month', 'category')
            ->selectRaw('MONTH(start) as month, category, COUNT(*) as task_count')
            ->orderBy('month')
            ->get();

        $categories = $tasks->unique('category')->map(function ($task) {
            return $task->category;
        })->toArray();

        $labels = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('F');
        }

        $datasets = [];
        foreach ($categories as $category) {
            $data = [];
            for ($i = 1; $i <= 12; $i++) {
                $task = $tasks->where('month', $i)->where('category', $category)->first();
                $data[] = $task ? $task->task_count : 0;
            }
            $datasets[] = [
                'label' => $category,
                'data' => $data,
                'pointRadius' => 0,
                'tension' => 0.4,
            ];
        }

        return response()->json(
            [
                'labels' => $labels,
                'datasets' => $datasets,
            ]
        );
    }
    public function hariini()
    {
        $tasks = Task::whereDate('start', Carbon::today())
            ->groupBy('category')
            ->selectRaw('category, COUNT(*) as task_count')
            ->get();

        $labels = $tasks->map(function ($task) {
            return $task->category;
        })->toArray();

        $data = $tasks->map(function ($task) {
            return $task->task_count;
        })->toArray();

        return response()->json(
            [
                'labels' => $labels,
                'data' => $data,
            ]
        );
    }
}

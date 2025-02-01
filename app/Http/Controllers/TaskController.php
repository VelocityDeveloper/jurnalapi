<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Ambil parameter dari request
        $user_id    = $request->input('user_id');
        $date       = $request->input('date') ?: date('Y-m');

        $query = Task::query();

        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        if ($date) {
            $query->whereMonth('start', now()->month);
        }

        $query->orderBy('start', 'asc');

        $tasks = $query->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'start'         => 'required',
            'end'           => 'required',
            'status'        => 'required',
            'category'      => 'required',
            'priority'      => 'required',
        ]);
        $user = $request->user();
        $validate['user_id'] = $user->id;

        //format tanggal
        $validate['start'] = date('Y-m-d H:i:s', strtotime($validate['start']));
        $validate['end'] = date('Y-m-d H:i:s', strtotime($validate['end']));

        $task = Task::create($validate);

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //dapatkan task
        $task = Task::find($id);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'start'         => 'required',
            'end'           => 'required',
            'status'        => 'required',
            'category'      => 'required',
            'priority'      => 'required',
        ]);
        $task = Task::find($id);

        //format tanggal
        $validate['start'] = date('Y-m-d H:i:s', strtotime($validate['start']));
        $validate['end'] = date('Y-m-d H:i:s', strtotime($validate['end']));

        $task->update($validate);

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //hapus task
        $task = Task::find($id);
        $task->delete();
    }
}

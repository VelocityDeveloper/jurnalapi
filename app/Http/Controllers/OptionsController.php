<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class OptionsController extends Controller
{
    //list option user
    public function users()
    {
        //get all users
        $users = User::all();

        //ubah struktur data
        $users = $users->map(function ($user) {
            return [
                'value' => $user->id,
                'label' => $user->name
            ];
        });

        return response()->json($users);
    }
}

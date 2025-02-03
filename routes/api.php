<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionsController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResources([
        'users'             => UsersController::class,
        'task'              => TaskController::class,
        'category'          => CategoryController::class
    ]);

    Route::get('options/users', [OptionsController::class, 'users']);
});

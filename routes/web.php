<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::any('adminer', [AdminerController::class, 'index'])->name('adminer');

Route::get('tasks/export', [TaskController::class, 'export'])->name('tasks.export');
Route::get('tasks/list', [TaskController::class, 'list'])->name('tasks.list');
Route::resource('tasks', TaskController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';


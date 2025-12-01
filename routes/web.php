<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserRoleController::class, 'updateRole'])->name('users.updateRole');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
});

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');


Route::middleware(['auth'])->group(function () {
    // Student rute
    Route::get('/available-tasks', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/tasks/{task}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    
    // Nastavnik rute
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');
    Route::put('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::put('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
});

require __DIR__.'/auth.php';

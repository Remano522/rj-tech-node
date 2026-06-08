<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Models\Cv;
use App\Models\Project;

Route::get('/', function () {
    $projects = Project::latest()->get();
    $cvs = Cv::orderBy('name')->get();

    return view('welcome', compact('projects', 'cvs'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/account/profile', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/account/password', [AuthController::class, 'updatePassword'])->name('admin.password.update');

    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('/projects/{project}/upload-photo', [ProjectController::class, 'uploadPhoto'])->name('projects.uploadPhoto');
    Route::post('/projects/{project}/remove-photo', [ProjectController::class, 'removePhoto'])->name('projects.removePhoto');

    Route::put('/cv/{cv}', [ProjectController::class, 'updateCv'])->name('cv.update');
});

<?php

use App\Http\Controllers\WPController;
use App\Http\Controllers\SAWController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\KaryawanController;

Route::get('/rekomendasi', function () {
    return Inertia::render('Rekomendasi');
})->name('rekomendasi');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('homepage');

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('homepage');

// Route::middleware('auth', 'role:admin,manager')->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Home');
    })->name('dashboard');

    Route::get('/inputdata', function () {
        return Inertia::render('DataForm');
    })->name('inputdata');

    Route::get('/matrix', function () {
        return Inertia::render('Matrix');
    })->name('matrix');

    Route::get('/preferensi', function () {
        return Inertia::render('Preferensi');
    })->name('preferensi');

    Route::get('/getdata', [KaryawanController::class, 'show']);

    // Input Data
    Route::post('/add', [KaryawanController::class, 'store']);
    Route::put('/update', [KaryawanController::class, 'update']);
    Route::delete('/{type}/{id}', [KaryawanController::class, 'destroy']);
    Route::post('/addsubcriteria/{id}', [KaryawanController::class, 'addSubCriteria']);

    Route::post('/addscore', [KaryawanController::class, 'addScore']);
    Route::get('/getscore', [KaryawanController::class, 'getScore']);

    Route::get('/saw/calculate', [SAWController::class, 'calculate'])->name('saw.calculate');
    Route::get('/wp/calculate', [WPController::class, 'calculate'])->name('wp.calculate');

    // Profile
    Route::get('/username', [ProfileController::class, 'get']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

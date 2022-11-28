<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teams
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.create')->middleware('admin');

    // Games
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create')->middleware('admin');
    Route::post('/games', [GameController::class, 'store'])->name('games.store')->middleware('admin');
    Route::get('/games/edit/{game}', [GameController::class, 'edit'])->name('games.edit')->middleware('admin');
    Route::patch('/games/update/{game}', [GameController::class, 'update'])->name('games.update')->middleware('admin');

    // Users
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('users.index');

    // Predictions
    Route::get('/predictions', [PredictionController::class, 'index'])->name('predictions.index');
    Route::get('/predictions/create', [PredictionController::class, 'create'])->name('predictions.create');
    Route::post('/predictions', [PredictionController::class, 'store'])->name('predictions.store')->middleware('admin-or-owner');
    Route::get('/predictions/edit/{prediction}', [PredictionController::class, 'edit'])->name('predictions.edit');
    Route::patch('/predictions/update/{prediction}', [PredictionController::class, 'update'])->name('predictions.update')->middleware('admin-or-owner');
});


require __DIR__ . '/auth.php';

<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\ExerciceController;

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
        'phpVersion' => PHP_VERSION
    ]);
});

//Tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//Machines
Route::resource('machines', MachineController::class)->middleware(['auth', 'verified'])->names('machines');

//Machines
Route::resource('seances', SeanceController::class)->middleware(['auth', 'verified'])->names('seances');

//Exercices
Route::resource('seances.exercices', ExerciceController::class)->names('exercices')->middleware('auth');
Route::get('/exercices/get_last_input/{machine}', [ExerciceController::class, 'getLastInput'])->middleware(['auth', 'verified'])->name('exercices.get_last_input');

require __DIR__.'/auth.php';
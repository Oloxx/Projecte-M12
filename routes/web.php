<?php

use App\Http\Controllers\ContacteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CollaboracioController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PATHS FOR ADDED CONTROLLERS
    // EMPRESA CONTROLLER
    Route::get('/empresa/index', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa_create');
    Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa_store');
    Route::get('/empresa/show/{id}', [EmpresaController::class, 'show'])->name('empresa_show');
    Route::get('/empresa/edit/{id}', [EmpresaController::class, 'edit'])->name('empresa_edit');
    Route::put('/empresa/update/{id}', [EmpresaController::class, 'update'])->name('empresa_update');
    Route::DELETE('/empresa/delete/{id}', [EmpresaController::class, 'delete'])->name('empresa_delete');
});

require __DIR__ . '/auth.php';






// COL·LABORACIÓ CONTROLLER

Route::get('/collaboracio/index', [CollaboracioController::class, 'index'])->name('collaboracio_index');

Route::get('/collaboracio/create', [CollaboracioController::class, 'create'])->name('collaboracio_create');

Route::post('/collaboracio/getcontactes', [CollaboracioController::class, 'getContactes'])->name('collaboracio_getcontactes');

Route::post('/collaboracio/store', [CollaboracioController::class, 'store'])->name('collaboracio_store');

Route::get('/collaboracio/edit/{id}', [CollaboracioController::class, 'edit'])->name('collaboracio_edit');

Route::put('/collaboracio/update/{id}', [CollaboracioController::class, 'update'])->name('collaboracio_update');

Route::DELETE('/collaboracio/delete/{id}', [CollaboracioController::class, 'delete'])->name('collaboracio_delete');

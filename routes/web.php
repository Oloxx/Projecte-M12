<?php

use App\Http\Controllers\ContacteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CollaboracioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TesterController;
use App\Http\Controllers\WelcomeController;

use Illuminate\Support\Facades\Route;

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


Route::match(['get', 'post'], '/', [WelcomeController::class, 'index'])->name('welcome.index');

//Route::post('/', [WelcomeController::class, 'store'])->name('contact.us.store');

Route::middleware(['auth', 'default.password'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/language/{lang}', [ProfileController::class, 'setLanguage'])->name('proflie.setLanguage');

    // PATHS FOR ADDED CONTROLLERS
    // EMPRESA CONTROLLER
    Route::match(['get', 'post'], '/empresa', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::get('/empresa/{id}', [EmpresaController::class, 'show'])->name('empresa.show');
    Route::get('/empresa/edit/{id}', [EmpresaController::class, 'edit'])->name('empresa.edit');
    Route::put('/empresa/update/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
    Route::delete('/empresa/delete/{id}', [EmpresaController::class, 'delete'])->name('empresa.delete');
    Route::match(['get', 'post'], '/empresa/search', [EmpresaController::class, 'search'])->name('empresa.search');
    Route::post('/removeLogo/{id}', [EmpresaController::class, 'removeLogo'])->name('empresa.removeLogo');

    // COL·LABORACIÓ CONTROLLER
    Route::match(['get', 'post'], '/collaboracio', [CollaboracioController::class, 'index'])->name('collaboracio.index');
    Route::get('/collaboracio/show', [CollaboracioController::class, 'show'])->name('collaboracio.show');
    Route::get('/collaboracio/create/{id?}', [CollaboracioController::class, 'create'])->name('collaboracio.create');
    Route::post('/collaboracio/getcontactes', [CollaboracioController::class, 'getContactes'])->name('collaboracio.getcontactes');
    Route::post('/collaboracio/store', [CollaboracioController::class, 'store'])->name('collaboracio.store');
    Route::get('/collaboracio/edit/{id}', [CollaboracioController::class, 'edit'])->name('collaboracio.edit');
    Route::put('/collaboracio/update/{id}', [CollaboracioController::class, 'update'])->name('collaboracio.update');
    Route::delete('/collaboracio/delete/{id}', [CollaboracioController::class, 'delete'])->name('collaboracio.delete');

    // CONTACTE CONTROLLER
    Route::match(['get', 'post'], '/contacte', [ContacteController::class, 'index'])->name('contacte.index');
    Route::get('/contacte/show', [ContacteController::class, 'show'])->name('contacte.show');
    Route::get('/contacte/create/{id}', [ContacteController::class, 'create'])->name('contacte.create');
    Route::get('/contacte/createContacte', [ContacteController::class, 'createWithoutId'])->name('contacte.createWithoutId');
    Route::post('/contacte/getcontactes', [ContacteController::class, 'getContactes'])->name('contacte.getcontactes');
    Route::post('/contacte/store', [ContacteController::class, 'store'])->name('contacte.store');
    Route::get('/contacte/edit/{id}', [ContacteController::class, 'edit'])->name('contacte.edit');
    Route::put('/contacte/update/{id}', [ContacteController::class, 'update'])->name('contacte.update');
    Route::delete('/contacte/delete/{id}', [ContacteController::class, 'delete'])->name('contacte.delete');
});

Route::group(['middleware' => 'admin'],function () {
    Route::post('/importCSV', [EmpresaController::class, 'importCSV'])->name('empresa.importCSV');
});

Route::middleware('auth')->group(function () {
    Route::get('/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::patch('/updatePassword', [ProfileController::class, 'updateDefaultPassword'])->name('profile.updateDefaultPassword');
});

Route::get('/test', [TesterController::class, 'test'])->name('test');

require __DIR__ . '/auth.php';

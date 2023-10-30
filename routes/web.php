<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AppController::class, 'index'])->name('index');
Route::get('/connexion', [AppController::class, 'login'])->name('login');
Route::get('/inscription', [AppController::class, 'register'])->name('register');
Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
Route::get('/parametres', [AppController::class, 'parameters'])->name('parameters');
Route::get('/logout', [AppController::class, 'logout'])->name('logout');

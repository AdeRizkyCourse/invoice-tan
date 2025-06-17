
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


//Auth Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function (){
// Invoice Routes
Route::get('/', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices.index');

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// User Routes
Route::resource('users', UserController::class);

// Client Routes
Route::resource('clients', ClientsController::class);

// Invoices Routes
Route::resource('invoices', InvoicesController::class);
});

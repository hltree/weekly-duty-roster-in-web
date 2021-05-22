<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoSchedulingController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth.admin');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('dashboard', [DashboardController::class, 'store'])->name('schedule-active-change')->middleware('auth');

Route::get('auto_scheduling', [AutoSchedulingController::class, 'index'])->name('auto_scheduling')->middleware('auth.admin');

<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('login', [HomeController::class, 'loginForm'])->withoutMiddleware('auth:admin')->name('login');
    Route::post('login', [HomeController::class, 'login'])->withoutMiddleware('auth:admin')->name('do.login');
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('users', [HomeController::class, 'storeUser'])->name('store.user');

    Route::get('deposit', [TransactionController::class, 'depositIndex'])->name('deposit');
    Route::post('deposit', [TransactionController::class, 'depositStore'])->name('deposit.store');

    Route::get('withdraw', [TransactionController::class, 'withdrawIndex'])->name('withdraw');
    Route::post('withdraw', [TransactionController::class, 'withdrawStore'])->name('withdraw.store');
    

    
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
// Auth::routes(['register' => false]); // Disable the default register route


Route::post('/users', [RegisterController::class, 'register'])->name('user.create');
Route::middleware(['auth'])->group(function () {
    //After Login the routes are accept by the loginUsers...
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // user deposit routes start
    Route::get('/deposit', [DepositController::class, 'index'])->name('show.deposit');
    Route::get('/create/deposit', [DepositController::class, 'create'])->name('create.deposit');
    Route::post('/deposit', [DepositController::class, 'store'])->name('store.deposit');
    // user deposit routes end
    
    
    // user withdrawal routes start
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('show.withdrawal');
    Route::get('/create/withdrawal', [WithdrawalController::class, 'create'])->name('create.withdrawal');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])->name('store.withdrawal');
    // user withdrawal routes end
});

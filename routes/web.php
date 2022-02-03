<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KeuntunganController;
// route dibawah ini error (not found) jdi saya comment
// use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

//HOMEPAGE
Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});


//DASHBOARD
Route::prefix('dashboard')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function () {
        // excel download route
        Route::post("/users/download",[UserController::class,'excel'])->name("users.excel");
        Route::get("/food/download",[FoodController::class,'excel'])->name("food.excel");
        Route::post("/transaction/download",[TransactionController::class,'excel'])->name("transaction.excel");
        Route::get("/kasmasuk/download",[KasMasukController::class,'excel'])->name("kasmasuk.excel");
        Route::post("/kaskeluar/download",[KasKeluarController::class,'excel'])->name("kaskeluar.excel");
        Route::post("/keuntungan/download",[KeuntunganController::class,'excel'])->name("keuntungan.excel");
        // end excel donwload route

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        // Route::resource('password', PasswordController::class);
        Route::resource('food', FoodController::class);
        Route::get('transactions/{id}/status/{status}', [TransactionController::class, 'changeStatus'])->name('transactions.changeStatus');
        Route::resource('transactions', TransactionController::class);
        Route::resource('kasmasuk', KasMasukController::class);
        Route::resource('kaskeluar', KasKeluarController::class);
        Route::resource('keuntungan', KeuntunganController::class);

        // route dibawah ini error (not found), jadi saya comment
        // Route::get('password', [PasswordController::class, 'edit'])
        // ->name('users.password.edit');
    });
//midtrans related
Route::get('midtrans/success', [MidtransController::class, 'success']);
Route::get('midtrans/unfinish', [MidtransController::class, 'unfinish']);
Route::get('midtrans/error', [MidtransController::class, 'error']);

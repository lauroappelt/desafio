<?php

use App\Http\Controllers\CreateTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user', [UserController::class, 'createUser'])->name('api.user.create');
Route::get('user', [UserController::class, 'listUsers'])->name('api.user.list');

//acredito nao estar semanticamente correto
Route::put('user', [UserController::class, 'addBalance'])->name('api.user.balance');

Route::post('transaction', [CreateTransactionController::class, 'createTransaction'])->name('api.create.transaction');

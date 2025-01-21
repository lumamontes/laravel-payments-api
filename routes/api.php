<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalancesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserDashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

  Route::get('/invoices', [InvoicesController::class, 'index']);
  Route::post('/invoices', [InvoicesController::class, 'store']);
  Route::get('/invoices/{id}', [InvoicesController::class, 'show']);
  Route::put('/invoices/{id}', [InvoicesController::class, 'update']);
  Route::delete('/invoices/{id}', [InvoicesController::class, 'destroy']);

  Route::get('/transactions', [TransactionsController::class, 'index']);
  Route::post('/transactions', [TransactionsController::class, 'store']);

  Route::get('/balance', [BalancesController::class, 'show']);
});
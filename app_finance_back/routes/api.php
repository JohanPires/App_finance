<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\TransactionController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/transaction/{id}', [TransactionController::class, 'index']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('/transaction/{id}', [TransactionController::class, 'delete']);
    Route::get('/transaction/total/{id}', [TransactionController::class, 'totalAmount']);
    Route::get('/categorie', [CategorieController::class, 'index']);
});


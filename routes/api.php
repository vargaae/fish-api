<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FishController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

#Login-Registration
Route::post('/login', [UserController::class, 'Login']);
Route::post('/registration', [UserController::class, 'Reg']);
#FISH
Route::get("/fish", [FishController::class, 'All']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/fish', [FishController::class, 'Add']);
//     Route::delete('fish/{id}', [FishController::class, 'Delete']);
// });
Route::middleware('auth.token')->group(function () {
    Route::post('/fish', [FishController::class, 'Add']);
    Route::delete('/fish/{id}', [FishController::class, 'Delete']);
});

<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TransformController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ImageMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/info', function(){
    return response()->json([
        
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/upload', [ImageController::class, 'upload'])->name('upload');
    Route::get('/image/{id}', [ImageController::class, 'show'])->name('image.show');

    Route::post('/image/{id}/transform', [TransformController::class, 'store'])->name('image.transform');
});
    
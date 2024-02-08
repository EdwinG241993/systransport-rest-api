<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//Define the route group using Route::group.
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => ['jwt.verify']], function () {
    //Todo lo que este dentro de este grupo requiere verificación de usuario.
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
    Route::post('delete-user', [AuthController::class, 'destroy']);
});

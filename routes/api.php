<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliatedCompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;

//Define the route group using Route::group - Unauthorized 

//Routes login, register
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

//Routes affiliated company - Unauthorized
Route::get('empresas-afiliadas', [AffiliatedCompanyController::class, 'index']);
Route::get('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'show']);

//Routes employee - Unauthorized
Route::get('funcionarios', [EmployeeController::class, 'index']);
Route::get('funcionarios/{id}', [EmployeeController::class, 'show']);

//Routes client - Unauthorized
Route::get('clientes', [ClientController::class, 'index']);
Route::get('clientes/{id}', [ClientController::class, 'show']);
Route::group(['middleware' => ['jwt.verify']], function () {
    //All of this requires user verification

    //Routes authentication - User Verification
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
});

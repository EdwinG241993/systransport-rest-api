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
    Route::delete('delete-user/{id}', [AuthController::class, 'destroy']);

    //Routes affiliated company - User Verification
    Route::post('empresas-afiliadas', [AffiliatedCompanyController::class, 'store']);
    Route::patch('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'update']);
    Route::delete('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'destroy']);

    ////Routes employee - User Verification
    Route::post('funcionarios', [EmployeeController::class, 'store']);
    Route::patch('funcionarios/{id}', [EmployeeController::class, 'update']);
    Route::delete('funcionarios/{id}', [EmployeeController::class, 'destroy']);
    
    //Routes client - User Verification
    Route::post('clientes', [ClientController::class, 'store']);
    Route::patch('clientes/{id}', [ClientController::class, 'update']);
    Route::delete('clientes/{id}', [ClientController::class, 'destroy']);
});

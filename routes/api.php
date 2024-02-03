<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliatedCompanyController;

//Define the route group using Route::group
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);
Route::get('empresas-afiliadas', [AffiliatedCompanyController::class, 'index']);
Route::get('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'show']);
Route::group(['middleware' => ['jwt.verify']], function () {
    //All of this requires user verification
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
    Route::post('empresas-afiliadas', [AffiliatedCompanyController::class, 'store']);
    Route::patch('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'update']);
    Route::delete('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'destroy']);
});

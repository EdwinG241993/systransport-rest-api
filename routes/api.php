<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliatedCompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TurnController;

//Define the route group using Route::group - Unauthorized 

//Routes login, register
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

//Access paths for authenticated users
Route::group(['middleware' => ['jwt.verify']], function () {
    //All of this requires user verification

    //Routes authentication - User Verification
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
    Route::delete('delete-user/{id}', [AuthController::class, 'destroy']);
});

//Access paths for administrators
Route::group(['middleware' => ['jwt.verify', 'role:Administrador']], function () {
    //All of this requires user verification and role administrator

    //Routes affiliated company - User Verification
    Route::get('empresas-afiliadas', [AffiliatedCompanyController::class, 'index']);
    Route::get('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'show']);
    Route::post('empresas-afiliadas', [AffiliatedCompanyController::class, 'store']);
    Route::patch('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'update']);
    Route::delete('empresas-afiliadas/{id}', [AffiliatedCompanyController::class, 'destroy']);

    ////Routes employee - User Verification
    Route::get('funcionarios', [EmployeeController::class, 'index']);
    Route::get('funcionarios/{id}', [EmployeeController::class, 'show']);
    Route::post('funcionarios', [EmployeeController::class, 'store']);
    Route::patch('funcionarios/{id}', [EmployeeController::class, 'update']);
    Route::delete('funcionarios/{id}', [EmployeeController::class, 'destroy']);

    //Routes conductor - User Verification
    Route::post('conductores', [ConductorController::class, 'store']);
    Route::patch('conductores/{id}', [ConductorController::class, 'update']);
    Route::delete('conductores/{id}', [ConductorController::class, 'destroy']);
    Route::get('conductores', [ConductorController::class, 'index']);
    Route::get('conductores/{id}', [ConductorController::class, 'show']);

    //Routes car - User Verification
    Route::post('vehiculos', [CarController::class, 'store']);
    Route::patch('vehiculos/{id}', [CarController::class, 'update']);
    Route::delete('vehiculos/{id}', [CarController::class, 'destroy']);
    Route::get('vehiculos', [CarController::class, 'index']);
    Route::get('vehiculos/{id}', [CarController::class, 'show']);

    //Routes route - User Verification
    Route::post('rutas', [RouteController::class, 'store']);
    Route::patch('rutas/{id}', [RouteController::class, 'update']);
    Route::delete('rutas/{id}', [RouteController::class, 'destroy']);
    Route::get('rutas', [RouteController::class, 'index']);
    Route::get('rutas/{id}', [RouteController::class, 'show']);

    //Routes turns - User Verification
    Route::post('turnos', [TurnController::class, 'store']);
    Route::patch('turnos/{id}', [TurnController::class, 'update']);
    Route::delete('turnos/{id}', [TurnController::class, 'destroy']);
    Route::get('turnos', [TurnController::class, 'index']);
    Route::get('turnos/{id}', [TurnController::class, 'show']);
});

//Access paths for employees
Route::group(['middleware' => ['jwt.verify', 'role:Funcionario']], function () {
    //Routes client - Unauthorized
    Route::get('clientes', [ClientController::class, 'index']);
    Route::get('clientes/{id}', [ClientController::class, 'show']);
    Route::post('clientes', [ClientController::class, 'store']);
    Route::patch('clientes/{id}', [ClientController::class, 'update']);
    Route::delete('clientes/{id}', [ClientController::class, 'destroy']);

    //Routes ticket - Unauthorized
    Route::get('tiquetes', [TicketsController::class, 'index']);
    Route::get('tiquetes/{id}', [TicketsController::class, 'show']);
    Route::post('tiquetes', [TicketsController::class, 'store']);
    Route::patch('tiquetes/{id}', [TicketsController::class, 'update']);
    Route::delete('tiquetes/{id}', [TicketsController::class, 'destroy']);
});

//Access paths for conductors
Route::group(['middleware' => ['jwt.verify', 'role:Conductor']], function () {
    //Routes conductor - User Verification
    Route::post('conductores', [ConductorController::class, 'store']);
    Route::patch('conductores/{id}', [ConductorController::class, 'update']);
    Route::delete('conductores/{id}', [ConductorController::class, 'destroy']);
    Route::get('conductores', [ConductorController::class, 'index']);
    Route::get('conductores/{id}', [ConductorController::class, 'show']);

    //Routes car - User Verification
    Route::post('vehiculos', [CarController::class, 'store']);
    Route::patch('vehiculos/{id}', [CarController::class, 'update']);
    Route::delete('vehiculos/{id}', [CarController::class, 'destroy']);
    Route::get('vehiculos', [CarController::class, 'index']);
    Route::get('vehiculos/{id}', [CarController::class, 'show']);

    //Routes route - User Verification
    Route::post('rutas', [RouteController::class, 'store']);
    Route::patch('rutas/{id}', [RouteController::class, 'update']);
    Route::delete('rutas/{id}', [RouteController::class, 'destroy']);
    Route::get('rutas', [RouteController::class, 'index']);
    Route::get('rutas/{id}', [RouteController::class, 'show']);

    //Routes turns - User Verification
    Route::post('turnos', [TurnController::class, 'store']);
    Route::patch('turnos/{id}', [TurnController::class, 'update']);
    Route::delete('turnos/{id}', [TurnController::class, 'destroy']);
    Route::get('turnos', [TurnController::class, 'index']);
    Route::get('turnos/{id}', [TurnController::class, 'show']);
});

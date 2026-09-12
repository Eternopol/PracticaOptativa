<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\RentaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Estas rutas se cargan automáticamente por el RouteServiceProvider
| dentro del grupo con middleware "api".
*/

// Clientes
Route::apiResource('clientes', ClienteController::class);

// Peliculas
Route::apiResource('peliculas', PeliculaController::class);

// Rentas
Route::apiResource('rentas', RentaController::class);

/*
|--------------------------------------------------------------------------
| Esto genera automáticamente:
|--------------------------------------------------------------------------
| GET    /api/clientes            -> index
| POST   /api/clientes            -> store
| GET    /api/clientes/{id}       -> show
| PUT    /api/clientes/{id}       -> update
| PATCH  /api/clientes/{id}       -> update
| DELETE /api/clientes/{id}       -> destroy
|
| (Lo mismo aplica para /api/peliculas y /api/rentas)
*/
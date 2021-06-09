<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstalationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// prueba debug sentry
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('install', [InstalationController::class, 'getInstalation']);

Route::get('mail', [AuthController::class, 'mail']);


Route::get('login', function () {
    $mensaje = '[Error]: Actualmente no tiene permisos suficientes para acceder a la ruta '. date('l jS \of F Y h:i:s A');
    Log::error($mensaje);
    return response()->json(['error' => $mensaje, 'status' => 401], 401);
})->name('login');

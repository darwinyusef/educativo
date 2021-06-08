<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'registerStore']);

Route::get('validarmail/{id}', [AuthController::class, 'verifyMailShow']);
Route::post('validarmail/{id}', [AuthController::class, 'verifyMail']);

Route::get('autodelete/{id}', [UserController::class, 'destroy']);


// para incluir en los subdominios es / en -> Route::domain('{account}.example.com')->group(function () {

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('users', UserController::class)->names('user');
    Route::get('users/{uuid}/restore', [UserController::class, 'restore']);

    Route::get('/pruebita', function(){
        return 'Entramos sin problemas con sactrum';
    });
});




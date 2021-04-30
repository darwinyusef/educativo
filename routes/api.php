<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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

Route::get('login', 'App\Http\Controllers\AuthController@login');


// para incluir en los subdominios es / en -> Route::domain('{account}.example.com')->group(function () {

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('users', UserController::class)->names('user');
    Route::get('users/{uuid}/restore', [UserController::class, 'restore']);

    Route::get('/pruebita', function(){
        return 'Entramos sin problemas con sactrum';
    });
});




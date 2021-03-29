<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('pass', 'App\Http\Controllers\AuthController@index')->name('home');
Route::get('crear/token', 'App\Http\Controllers\AuthController@creadito');

Route::middleware('auth:sanctum')->get('/pruebita', function(){
    return 1;
});


Route::get('login', [ 'as' => 'login', 'uses' => 'AuthController@login']);

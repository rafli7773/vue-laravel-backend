<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::post('/login', 'LoginController@index');
    Route::post('/register', 'RegisterController@index');
    Route::get('/logout', 'LoginController@logout');
});

Route::prefix('/posts')->group(function () {
    Route::get('/', 'PostController@index');
    Route::post('/create', 'PostController@store');
    Route::get('/join', 'PostController@join');
    Route::put('/{post:slug}/edit', 'PostController@update');
    Route::delete('/{post:slug}/delete', 'PostController@destroy');
    Route::get('/{post:slug}/show', 'PostController@show');
    Route::post('/search', 'PostController@search');
});

Route::prefix('/join')->group(function () {
    Route::get('/', 'JoinController@index');
    Route::post('/create', 'JoinController@store');
    Route::get('/{user:id}/show', 'JoinController@show');
});

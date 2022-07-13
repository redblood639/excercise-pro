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

Route::get('cruds', 'App\Http\Controllers\ApiController@getAllCRUDS');
Route::get('cruds/{id}', 'App\Http\Controllers\ApiController@getCRUD');
Route::post('cruds/create', 'App\Http\Controllers\ApiController@createCRUD');
Route::put('cruds/{id}', 'App\Http\Controllers\ApiController@updateCRUD');
Route::delete('cruds/{id}','App\Http\Controllers\ApiController@deleteCRUD');
<?php

use Illuminate\Http\Request;

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

Route::resource('locations', 'Api\LocationController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('categories', 'Api\CategoryController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('items', 'Api\ItemController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('reports', 'Api\ReportController', ['only' => ['index']]);
Route::post('reports/filter', 'Api\ReportController@filter');

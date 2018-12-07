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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('operations/{id}', 'UserController@getOperations'); // Получить все операции конкретного пользователя
    Route::get('operations/category/all/{id}', 'UserController@getCategoryOperations');
    
    Route::post('operation/create', 'OperationController@create');
    Route::post('operation/delete/{id}', 'OperationController@destroy');
    Route::put('operation/update/{id}', 'OperationController@update');
    Route::get('operation/view/{id}', 'OperationController@show');

    Route::post('operations/category/create', 'OperationTypeController@create');
    Route::post('operations/category/get', 'OperationTypeController@show');
    Route::post('operations/category/delete', 'OperationTypeController@destroy');

    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});
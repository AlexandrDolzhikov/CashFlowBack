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
    
    Route::post('operations/create', 'OperationController@create');
    Route::post('operations/delete/{id}', 'OperationController@destroy');
    Route::put('operations/update/{id}', 'OperationController@update');
    Route::get('operations/view/{id}', 'OperationController@show');

    Route::post('operations/category/create', 'OperationTypeController@create');
    Route::post('operations/category/get', 'OperationTypeController@show');
    Route::post('operations/category/delete', 'OperationTypeController@destroy');

    Route::get('users/get_auth', 'UserController@getAuthenticatedUser');
    Route::post('users/get_me', 'UserController@getTheUserInfo');
    Route::post('users/update', 'UserController@updateTheUserInfo');
    Route::post('users/delete', 'UserController@deleteTheUser');

});
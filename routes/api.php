<?php

use Illuminate\Http\Request;

Route::post("login", "API\LoginController@login");

Route::group(['prefix' => 'users'], function(){
    Route::get('/', 'API\UserController@index');
    Route::get('/{id}', 'API\UserController@details');
    Route::post('/', 'API\UserController@create');
    Route::put('/{id}', 'API\UserController@update');
    Route::delete('/{id}', 'API\UserController@delete');
});

Route::group(['prefix' => 'roles'], function(){
    Route::get('/', 'API\RoleController@index');
    Route::get('/{id}', 'API\RoleController@details');
    Route::post('/', 'API\RoleController@create');
    Route::put('/{id}', 'API\RoleController@update');
    Route::delete('/{id}', 'API\RoleController@delete');
});

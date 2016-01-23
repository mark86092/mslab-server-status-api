<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('api/machines', 'MachineController@index');
Route::patch('api/machines', 'MachineController@update');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //Route::auth();
    // Authentication Routes...
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');
    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {
        Route::get('/', 'AdminController@index');
        Route::patch('/', 'AdminController@updateProfile');

        Route::get('machines', 'MachineController@index');
        Route::get('machines/{machine}/edit', 'MachineController@edit');
        Route::patch('machines/{machine}', 'MachineController@update');
        Route::post('machines', 'MachineController@store');
        Route::delete('machines/{machine}', 'MachineController@destroy');
        Route::post('machines/{machine}/token', 'MachineScopeController@store');
        Route::delete('machines/{machine}/token/{scope_id}', 'MachineScopeController@destroy');
    });
});

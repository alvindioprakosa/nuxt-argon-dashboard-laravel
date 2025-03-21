<?php

use Illuminate\Support\Facades\Route;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

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

// Authentication Routes (Login, Register, Password Reset, etc.)
Route::namespace('Api\V1\Auth')->prefix('api/v1')->middleware('json.api')->group(function () {
    Route::post('/login', 'LoginController')->name('auth.login');
    Route::post('/register', 'RegisterController')->name('auth.register');
    Route::post('/logout', 'LogoutController')->middleware('auth:api')->name('auth.logout');
    Route::post('/password-forgot', 'ForgotPasswordController')->name('auth.password.forgot');
    Route::post('/password-reset', 'ResetPasswordController')->name('auth.password.reset');
});

// JsonApi Resources Routes (Users, Me)
JsonApi::register('v1')->middleware('auth:api')->routes(function ($api) {
    // Routes for user profile actions (GET and PATCH)
    $api->get('me', 'Api\V1\MeController@readProfile')->name('me.read');
    $api->patch('me', 'Api\V1\MeController@updateProfile')->name('me.update');

    // User resource routes (CRUD for users)
    $api->resource('users')->name('users');
});

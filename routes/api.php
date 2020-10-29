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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/categories/')->namespace('Admin\\')->group(function () {
    Route::get('', 'CategoriesController@getCategories')->name('categories');
    Route::get('{id}', 'CategoriesController@getCategory')->name('category');
    Route::post('', 'CategoriesController@createCategory')->name('createCategory');
    Route::delete('{id}', 'CategoriesController@deleteCategory')->name('deleteCategory');
    Route::put('{id}', 'CategoriesController@updateCategory')->name('updateCategory');
});

Route::prefix('v1/nexmo/')->namespace('Sms\\')->group(function () {
    Route::post('stripe/webhook', 'WebhookController@handle')->name('webhook');
});



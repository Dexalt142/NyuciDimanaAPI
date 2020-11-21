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

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'Auth\LoginController@login')->name('api.auth.login');
    Route::post('register', 'Auth\RegisterController@register')->name('api.auth.register');

    Route::group(['middleware' => ['api.auth']], function() {
        Route::get('me', 'Auth\SessionController@getUser')->name('api.auth.me');
        Route::post('logout', 'Auth\SessionController@logout')->name('api.auth.logout');
    });
});

Route::group(['middleware' => ['api.auth']], function() {

    Route::group(['prefix' => 'laundromat'], function() {
        Route::get('/', 'LaundromatController@getLaundromats')->name('api.laundromat');
        Route::get('my', 'LaundromatController@getUserLaundromat')->name('api.laundromat.my');
        Route::get('{id}', 'LaundromatController@getLaundromat')->name('api.laundromat.get');
        Route::post('/create', 'LaundromatController@createLaundromat')->name('api.laundromat.create');
    });
});

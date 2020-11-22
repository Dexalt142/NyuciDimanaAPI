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

    Route::group(['prefix' => 'transaction'], function() {
        
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', 'TransactionController@getUserAllTransactions')->name('api.transaction.user');
            Route::get('{id}', 'TransactionController@getUserTransaction')->name('api.transaction.user.get');
        });

        Route::get('/', 'TransactionController@getLaundromatAllTransactions')->name('api.transaction');
        Route::get('{id}', 'TransactionController@getLaundromatTransaction')->name('api.transaction.get');
    });

});

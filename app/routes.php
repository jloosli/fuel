<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group( array( 'prefix' => 'api/v1' ), function () {
    Route::resource( 'users', 'UserController' );

    Route:: group( array( 'prefix' => 'vouchers' ), function () {
        Route::get( '', [ 'as' => 'allVouchers', 'uses' => 'VoucherController@index' ] );
        Route::get( '{id}', [ 'as' => 'allVouchers', 'uses' => 'VoucherController@show' ] );
        Route::put( '{id}', [ 'as' => 'updateVoucher', 'uses' => 'VoucherController@update' ] );
    } );

    Route::group( [ 'prefix' => 'checks' ], function () {
        Route::get( '', [ 'as' => 'allChecks', 'uses' => 'CheckController@index' ] );
        Route::post( '', [ 'as' => 'addCheck', 'uses' => 'CheckController@create' ] );
        Route::get( '{id}', [ 'as' => 'checkInfo', 'uses' => 'CheckController@show' ] );
        Route::post( '{id}/vouchers', [ 'as' => 'issueVouchers', 'uses' => 'VouchersController@create' ] );
    } );
} );


Route::get( '/', function () {
    return View::make( 'hello' );
} );


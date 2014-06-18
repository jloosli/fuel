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

Route::api( array( 'version' => 'v1' ), function () {
    Route::resource( 'users', 'UserController' );

    Route::group( array( 'prefix' => 'vouchers' ), function () {
        Route::get( '', [ 'as' => 'allVouchers', 'uses' => 'VoucherController@index' ] );
        Route::get( '{id}', [ 'as' => 'getVoucher', 'uses' => 'VoucherController@show' ] );
        Route::put( '{id}', [ 'as' => 'updateVoucher', 'uses' => 'VoucherController@update' ] );
    } );

    Route::group( [ 'prefix' => 'checks' ], function () {
        Route::get( '', [ 'as' => 'allChecks', 'uses' => 'CheckController@index' ] );
        Route::post( '', [ 'as' => 'addCheck', 'uses' => 'CheckController@store' ] );
        Route::get( 'open', [ 'as' => 'openChecks', 'uses' => 'CheckController@getOpenChecks' ] );
        Route::get( '{id}', [ 'as' => 'checkInfo', 'uses' => 'CheckController@show' ] );
        Route::get( '{id}/vouchers', [ 'as' => 'showVouchersFromCheck', 'uses' => 'CheckController@getVouchers' ] );
        Route::post( '{id}/vouchers', [ 'as' => 'issueVouchers', 'uses' => 'CheckController@createVouchers' ] );
    } );
} );

Route::get( 'voucher/{id}', [ 'as' => 'getVoucher', 'uses' => 'VoucherController@show' ] );

Route::get('/vouchers/print/{vouchers}/{pdf?}', [
    'as'=>'printVouchers',
    'uses' => 'VoucherController@print_vouchers'
]);

Route::get( '/', function () {
    return Redirect::to('index.html');
    return View::make( 'hello' );
} );


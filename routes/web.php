<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');

    Route::post('withdrawn', 'BalanceController@withDrawnStore')->name('withdrawn.store');
    Route::get('withdrawn', 'BalanceController@withDrawn')->name('balance.withdrawn');

    Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');
    Route::post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');

    Route::get('balance', 'BalanceController@index')->name('admin.balance');

    Route::get('/', 'AdminController@index')->name('admin.home');
});


Route::get('/', 'Site\SiteController@index');

Auth::routes();



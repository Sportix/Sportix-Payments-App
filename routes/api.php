<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1'], function () {

    Route::get('/orders/all/{accountId}', ['uses' => 'Api\OrdersController@index']);
    Route::get('/orders/{id}', ['uses' => 'Api\OrdersController@show']);

});

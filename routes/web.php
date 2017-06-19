<?php

Route::get('/mockups/orders', function() {
   return view('orders.show');
});

//Crypt::decrypt();
//apc_clear_cache();
//dd(DB::getQueryLog());
//dd(new DateTime());
//dd(App::environment());
//dd(gethostname());
//Log::error('test');

// -------------------------------------------
// Marketing (Public) Routes
// -------------------------------------------
Route::get('/', function () { return view('welcome'); });


// -------------------------------------------
// Authentication Routes
// -------------------------------------------
Auth::routes();


// -------------------------------------------
// Account/Admin Visible Routes
// -------------------------------------------

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {

    Route::get('dashboard', 'DashboardController@index');
    Route::resource('payments', 'ProductsController');

});


// -------------------------------------------
// Public Payment Routes
// -------------------------------------------

Route::get('/p/{id}', 'Payments\ProductsController@show');
Route::post('/products/{id}/orders', 'Payments\ProductOrdersController@store');

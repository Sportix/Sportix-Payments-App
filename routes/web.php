<?php

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
// Account Visible Routes
// -------------------------------------------
Auth::routes();


Route::get('/dashboard', function () { return view('app.dashboard'); });

Route::resource('products', 'ProductsController');

Route::get('/home', 'HomeController@index');

// -------------------------------------------
// Public Payment Routes
// -------------------------------------------

Route::get('/p/{id}', 'Payments\ProductsController@show');
Route::post('/products/{id}/orders', 'Payments\ProductOrdersController@store');

// -------------------------------------------
// Admin Internal Routes
// -------------------------------------------

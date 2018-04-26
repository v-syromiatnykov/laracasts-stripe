<?php

//Route::get('/', function () {
//    $plans = App\Plan::all();
//
//    return view('welcome', compact('plans'));
//});

Route::post('/purchases', 'SubscriptionsController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/stripe/webhook', 'WebhooksController@handle');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

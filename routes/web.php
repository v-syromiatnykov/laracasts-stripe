<?php

//Route::get('/', function () {
//    $plans = App\Plan::all();
//
//    return view('welcome', compact('plans'));
//});

Route::post('/subscriptions', 'SubscriptionsController@store');
Route::patch('/subscriptions', 'SubscriptionsController@update');
Route::delete('/subscriptions', 'SubscriptionsController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/stripe/webhook', 'WebhooksController@handle');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/videos/{video}', 'VideosController@show');

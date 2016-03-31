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


Route::get('/', 'HomeController@showWelcome');

Route::post('/languageGet', 'HomeController@getLanguage');

Route::post('/languageSet', 'HomeController@setLanguage');

Route::get('/login', 'HomeController@loginPage'); //Janrain page - need to seperate out

Route::get('/coupons', 'CouponsController@index');

Route::post('/coupons', 'CouponsController@getBrandsSorted');

Route::get('/admin', 'AdminController@login');

Route::post('/admin', 'AdminController@handleLogin');

Route::get('/logout', 'AdminController@logout');

Route::post('/user','UserController@store');	


//Access Token
Route::group(array('before' => 'user.accesstoken'), function()
{
	Route::get('/shoppingcart/{userId}','ShoppingCartController@show');

	Route::post('/shoppingcart/{userId}','ShoppingCartController@addToCart');

	Route::delete('/shoppingcart/{userId}','ShoppingCartController@removeFromCart');

});

Route::post('/print','PrintingController@callPrint');

//Admin
Route::group(array('before' => 'auth'), function()
{

	Route::get('/dashboard', 'AdminController@dashboard');

	Route::get('adduser','AdminController@addUser');

	Route::post('saveuser','AdminController@saveUser');

	Route::get('/couponstatistics','CouponStatisticsController@index');

	Route::get('/couponstatistics/addToCart/{couponId}','CouponStatisticsController@addToCart');

	Route::get('/couponstatistics/removeFromCart/{couponId}','CouponStatisticsController@removeFromCart');
});


//Local route only
Route::group(array('before' => 'localCallOnly'), function()
{

	Route::get('/coupons/updateOrCreate', 'CouponsController@updateOrCreate');

});





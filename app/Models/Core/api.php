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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App'], function () {
    Route::post('/processlogin', 'CustomersController@processlogin');
    Route::post('/profile', 'CustomersController@profile');
    Route::post('/update-profile', 'CustomersController@updateProfile');
    Route::post('/process-forgot-password', 'CustomersController@processforgotpassword');
    Route::post('/logout', 'CustomersController@Logout');
    Route::post('/customer-register', 'CustomersController@processregistration');
    Route::post('/home', 'IndexController@index');
    Route::post('/all-categories', 'IndexController@allCategories');
    Route::post('/all-brands', 'IndexController@allBrands');
    Route::post('/get-currencies', 'IndexController@getCurrencies');

    Route::post('/products-by-category', 'ProductsController@shop');
    Route::post('/products-by-brand', 'ProductsController@shop');
    Route::post('/product-details', 'ProductsController@detail');
	Route::post('/cart/add/', 'CartController@add');
	Route::post('/cart/listing/', 'CartController@view');
	Route::post('/cart/delete/', 'CartController@delete');
    Route::post('/cart/update/', 'CartController@quantityUpdate');
    Route::post('/wishlist/add-or-remove/', 'WishlistController@addOrRemove');
    Route::post('/wishlist/list/', 'WishlistController@list');
    Route::post('/wishlist/delete/', 'WishlistController@delete');
	Route::post('/otp/varify/', 'IndexController@OtpVarify');
});
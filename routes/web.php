<?php
//web New_1

use App\Models\Core\Pages;
use Illuminate\Support\Facades\Artisan;

$middleware = ['installer'];

Route::get('/maintance', 'Web\IndexController@maintance');
Route::get('/test-forgot', function(){
$check = \App\Models\Web\Users::where('email','team.digitalsetgo@gmail.com')->first();
	return view('mail.forgot', [
    'title' => 'Forgot',
    'data' => $check
]);

});
Route::group(['namespace' => 'Web', 'middleware' => ['installer']], function () {
	Route::get('/login', 'CustomersController@login');
	Route::post('/process-login', 'CustomersController@processLogin');
	Route::get('/logout', 'CustomersController@logout')->middleware('Customer');
});
Route::post('/notifications/mark-read', 'Web\IndexController@markRead')
	->name('notifications.markRead');
	Route::post('/saved-cartitem-addresses', 'Web\IndexController@getSavedCartitemAddresses');
Route::group(['namespace' => 'Web', 'middleware' => $middleware], function () {


	Route::get('general_error/{msg}', function ($msg) {
		return view('errors.general_error', ['msg' => $msg]);
	});

	$pages = Pages::all();

	$pages = $pages ? $pages = $pages->toArray() : '';

	Route::get('career/{slug}', 'IndexController@careerCategory');
	Route::post('createBrevoContact', 'IndexController@createBrevoContact');
	Route::get('job/{slug}', 'IndexController@jobDetail');
	Route::get('blog/{slug}', 'IndexController@blogDetail');
	Route::get('event/{slug}', 'IndexController@eventDetail');
	Route::post('event/{slug}', 'IndexController@eventDetailQuote');

	foreach ($pages as $page) :

		Route::get($page['slug'], 'IndexController@renderPage');

	endforeach;

	Route::post('/geoplugin', 'IndexController@analytics');

	Route::get('/', 'IndexController@index');
	Route::get('/notifications', 'IndexController@notifications')->name('notifications');
	Route::post('/mailchimp-request', 'IndexController@mailchimpRequest');

	Route::get('load/{section}', 'IndexController@loadSection');

	Route::post('search-job', 'IndexController@jobSearch');

	Route::post('search-record', 'ProductsController@recordSearch');

	Route::post('get-sizes', 'IndexController@getSizes');

	Route::post('social-share', 'IndexController@socialShare');

	Route::post('inquiry', 'IndexController@inquiry');

	Route::post('apply/career', 'IndexController@inquiry');

	Route::post('help-center', 'IndexController@searchQuestion');

	Route::get('shop/featured', 'ProductsController@shop');
	Route::get('/store/{storename}', 'IndexController@storeDetail');
	Route::get('/stores', 'IndexController@stores')->name('web.stores');

	Route::get('shop/', 'ProductsController@shop');



	Route::get('shop/category/{category}', 'ProductsController@shop');

	Route::get('shop/deal/{deal}', 'ProductsController@shop');

	Route::get('shop/tag/{tag}', 'ProductsController@shop');

	Route::get('shop/brand/{brand}', 'ProductsController@shop');

	Route::post('shop/filter/', 'ProductsController@filter');

	Route::post('brandsearch', 'ProductsController@searchBrand');

	Route::post('products/search/', 'ProductsController@suggestions');

	// Product Routes

	Route::get('/product/{slug}', 'ProductsController@detail');

	Route::post('/product/comment', 'ProductsController@askQuestion');

	Route::post('/variation/relations', 'ProductsController@variationRelation');


	// Cart Routes

	Route::get('/cart/', 'CartController@view');
	Route::post('/save-cart-item-addresses/', 'CartController@saveCartItemAddresses');

	Route::post('/cart/add/', 'CartController@add');

	Route::post('/cart/qty', 'CartController@quantityUpdate');

	Route::post('/cart/update/', 'CartController@updateCart');

	Route::get('/cart/count/', 'CartController@cartCount');

	Route::post('/cart/empty', 'CartController@emptyCart');

	Route::get('/cart/removecoupon', 'CartController@removeCoupon');

	Route::post('/cart/applycoupon', 'CartController@applyCoupon');

	Route::post('/cart/usestorecredit', 'CartController@storeCredit');

	Route::post('/cart/moveitemtoorder', 'CartController@moveToOrder');

	Route::get('/cart/delete/{id}', 'CartController@deleteItem');

	// Wishlist Routes

	Route::get('/wishlist/', 'WishlistController@list');

	Route::post('/wishlist/addorremove/', 'WishlistController@addOrRemove');

	Route::post('/wishlist/removefromcart', 'WishlistController@removeFromCart');

	Route::post('/wishlist/add-cart/', 'WishlistController@addCart');

	Route::post('/wishlist/empty/', 'WishlistController@empty');

	Route::get('/wishlist/delete/{id}', 'WishlistController@removeItem');

	// Checkout Routes

	Route::post('timeslots/', 'ShippingAddressController@getTimeSlots');

	Route::post('check_area/', 'ShippingAddressController@checkArea');

	Route::post('slotprice/', 'ShippingAddressController@getSlotPrice');

	Route::post('update-checkout/', 'IndexController@updateCheckout');

	Route::get('/checkout/', 'IndexController@checkout');



	Route::post('/createcheckout/', 'CartController@checkout');

	// Checkout Routes

	Route::post('/place-order/', 'OrdersController@placeOrder');

	Route::post('/tracking/order', 'OrdersController@trackingViewOrder');


	Route::post('/order/changestatus', 'OrdersController@changeStatus');

	Route::get('/thankyou/{ID}', 'OrdersController@thankyou');

	Route::post('/change_currency', 'IndexController@changeCurrency');

	Route::post('/change_language', 'IndexController@changeLang');

	// Auth

	Route::post('/validate', 'CustomersController@validate');

	Route::post('/signup', 'CustomersController@register');

	Route::post('/auth-login', 'CustomersController@authenticate');

	Route::post('/signin', 'CustomersController@login');

	Route::get('/logout', 'CustomersController@logout');

	Route::get('check_user_register', 'CustomersController@check_user_register');

	Route::get('/forgot-password', 'CustomersController@forgot');

	Route::post('/auth/reset-email', 'CustomersController@resetEmail');

	Route::get('/reset-password/{username}', 'CustomersController@resetPassword');

	Route::post('/auth/reset', 'CustomersController@reset');


	// Dashboard


	Route::get('/account/payment-option', 'CustomersController@paymentOption')->middleware('Customer');
Route::get('/account/become-a-vendor', 'CustomersController@becomeSeller')->middleware('Customer');
	Route::post('/vendor/update', 'CustomersController@updateVendor')->middleware('Customer');

	Route::get('/account/wallet', 'CustomersController@wallet')->middleware('Customer');
	Route::post('/wallet-history/filter', 'CustomersController@filterWalletHistory')->name('wallet.history.filter');

	Route::get('/account/wallet-history', 'CustomersController@walletHistory')->middleware('Customer');

	Route::get('/account/track-order', 'CustomersController@trackOrder')->middleware('Customer');

	Route::post('/account/track-order', 'CustomersController@trackedOrder')->middleware('Customer');

	Route::get('/account/addresses', 'CustomersController@addresses')->middleware('Customer');

	Route::post('/add-address/', 'CustomersController@addAddresses')->middleware('Customer');

	Route::get('/get-addresses', 'CustomersController@getAddresses');

	Route::get('/address/remove/{key}', 'CustomersController@removeAddress')->middleware('Customer');

	Route::post('/account/update-address', 'CustomersController@updateAddresses')->middleware('Customer');

	Route::post('/set-default-address', 'CustomersController@setDefault')->middleware('Customer');


	Route::post('/auth/profile', 'CustomersController@updateProfile')->middleware('Customer');

	Route::post('/reorder-cart', 'OrdersController@addReorderCart')->middleware('Customer');

	Route::post('/cancel-status', 'CustomersController@update_order_status')->middleware('Customer');

	Route::post('/update-address', 'CustomersController@updateAddress')->middleware('Customer');

	Route::post('/update/password', 'CustomersController@updatePassword')->middleware('Customer');

	Route::post('/user-avatar', 'CustomersController@userAvatar')->middleware('Customer');

	Route::get('/account/orders', 'CustomersController@orders')->middleware('Customer');

	Route::get('/account/give-reviews', 'CustomersController@giveReviews')->middleware('Customer');

	Route::get('/account/order/{id}', 'CustomersController@orderDetail')->middleware('Customer');

	Route::get('/account/add-review/{id}', 'CustomersController@addReview')->middleware('Customer');


	Route::get('/account/wishlist', 'WishlistController@list')->middleware('Customer');

	Route::get('/account/{username}', 'CustomersController@user_account')->middleware('Customer');

	Route::get('my-account', 'CustomersController@MyAccount')->middleware('Customer');

	Route::get('/account/payment-option', 'CustomersController@paymentOption')->middleware('Customer');

	Route::post('submit-review', 'ReviewController@submit')->middleware('Customer');

	Route::post('/updateProfileAddress', 'CustomersController@updateProfileAddress');

	Route::get('/logoutt', 'CustomersController@logout')->middleware('Customer');

	Route::get('/forgotPassword', 'CustomersController@forgotPassword');

	Route::get('/recoverPassword', 'CustomersController@recoverPassword');

	Route::post('/processPassword', 'CustomersController@processPassword');




});




Route::get('/cache-clear', function () {
	Artisan::call('cache:clear');
});

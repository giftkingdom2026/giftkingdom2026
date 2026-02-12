<?php


// use App\Http\Controllers\WebpagesController;

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    // $exitCode = Artisan::call('config:cache');
});

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::group(['middleware' => ['installer']], function () {
    Route::get('/not_allowed', function () {
        return redirect('/');
    });
    
    Route::group(['namespace' => 'AdminControllers', 'prefix' => 'admin'], function () {

        Route::get('/login', 'AdminController@login');

        Route::post('/checkLogin', 'AdminController@checkLogin');

        Route::get('/developer', 'DeveloperController@view')->middleware('CheckIfAllowed');

        Route::post('/change_lang', 'SiteSettingController@changeLang')->middleware('CheckIfAllowed');

        Route::post('/setting/change_lang', 'SiteSettingController@changeLang')->middleware('CheckIfAllowed');

        Route::get('/developer/create', 'DeveloperController@create')->middleware('CheckIfAllowed');

        Route::get('/developer/template/edit/{id}', 'DeveloperController@edit')->middleware('CheckIfAllowed');

        Route::post('/template/fields', 'DeveloperController@get_field')->middleware('CheckIfAllowed');

        Route::post('/template/fields/save', 'DeveloperController@save')->middleware('CheckIfAllowed');

        Route::post('/template/fields/update', 'DeveloperController@update')->middleware('CheckIfAllowed');


    });

    Route::get('/home', function () {
        return redirect('/admin/languages/display');
    });



    Route::group(['namespace' => 'AdminControllers', 'middleware' => 'auth', 'prefix' => 'admin'], function () {

        Route::post('/template', 'AdminController@template')->middleware('CheckIfAllowed');
        
        Route::post('webPagesSettings/changestatus', 'ThemeController@changestatus');
        Route::post('webPagesSettings/setting/set', 'ThemeController@set');
        Route::post('webPagesSettings/reorder', 'ThemeController@reorder');
        Route::get('/home', function () {
            return redirect('/dashboard/');
        });

        Route::get('/generateKey', 'SiteSettingController@generateKey');

        //log out
        Route::get('/logout', 'AdminController@logout');
        Route::get('/webPagesSettings/{id}', 'ThemeController@index2');

        Route::get('/topoffer/display', 'ThemeController@topoffer');
        Route::post('/topoffer/update', 'ThemeController@updateTopOffer');

        Route::get('/deal/display', 'ThemeController@Deal');
        Route::post('/deal/update', 'ThemeController@updateDeal');
        
        Route::post('sort-order/{type}', 'AdminController@sorting')->middleware('CheckIfAllowed');

        Route::get('/dashboard/', 'AdminController@dashboard')->middleware('CheckIfAllowedVendor');

        
        Route::get('/dashboard2/', 'AdminController@dashboard2');

        Route::get('/contact-form', 'AdminController@ContactForm')->middleware('CheckIfAllowed');
        Route::get('/event-inquiries', 'AdminController@EventInquiryForm')->middleware('CheckIfAllowed');
        Route::get('/event-inquiry-ajax', 'AdminController@EventInquiryAjax')->middleware('CheckIfAllowed');
        
        Route::get('/contact-form-ajax', 'AdminController@ContactFormAjax')->middleware('CheckIfAllowed');

        Route::post('/contact-delete', 'AdminController@ContactDelete')->middleware('CheckIfAllowed');
        Route::post('/event-inquiry-delete', 'AdminController@EventInquiryDelete')->middleware('CheckIfAllowed');


        //add adddresses against customers
        Route::get('/addaddress/{id}/', 'CustomersController@addaddress')->middleware('CheckIfAllowed');
        Route::post('/addNewCustomerAddress', 'CustomersController@addNewCustomerAddress')->middleware('CheckIfAllowed');
        Route::post('/editAddress', 'CustomersController@editAddress')->middleware('CheckIfAllowed');
        Route::post('/updateAddress', 'CustomersController@updateAddress')->middleware('CheckIfAllowed');
        Route::post('/deleteAddress', 'CustomersController@deleteAddress')->middleware('CheckIfAllowed');
        Route::post('/getZones', 'AddressController@getzones');

        //////AbandonedCartController//////
        Route::get('/abandoned/cart/list', 'AbandonedCartController@ListAbandonedCart')->middleware('CheckIfAllowed');
        Route::get('/abandoned/cart/delete/{id}', 'AbandonedCartController@deleteAbandonedCart');
        Route::get('/abandoned/cart/email/{id}', 'AbandonedCartController@AbandonedCartEmail');
        Route::post('/abandoned/cart/send/mail/', 'AbandonedCartController@SendCartMail');


        //////RefOrders//////
        Route::get('/ref/order/list', 'OrdersController@refOrders');

        //Email Marketing 
        Route::get('/email/marketing/list', 'EmailMarketingController@test');
    });

    Route::group(['prefix' => 'admin/languages', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/display', 'LanguageController@display')->middleware('CheckIfAllowed');
        Route::post('/default', 'LanguageController@default')->middleware('CheckIfAllowed');
        Route::get('/add', 'LanguageController@add')->middleware('CheckIfAllowed');
        Route::post('/add', 'LanguageController@insert')->middleware('CheckIfAllowed');
        Route::get('/edit/{id}', 'LanguageController@edit')->middleware('CheckIfAllowed');
        Route::post('/update', 'LanguageController@update')->middleware('CheckIfAllowed');
        Route::post('/delete', 'LanguageController@delete')->middleware('CheckIfAllowed');
        Route::get('/filter', 'LanguageController@filter')->middleware('CheckIfAllowed');

    });

    // Developer Routes

    Route::group(['prefix' => 'admin/media', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/load_more', 'MediaController@loadMoreImage')->middleware('CheckIfAllowed');

        Route::get('/display', 'MediaController@display')->middleware('CheckIfAllowed');
        
        Route::get('/add', 'MediaController@add')->middleware('CheckIfAllowed');

        Route::post('/updatemediasetting', 'MediaController@updatemediasetting')->middleware('CheckIfAllowed');
        
        Route::post('/updatealt', 'MediaController@updateAlt')->middleware('CheckIfAllowed');

        Route::post('/uploadimage', 'MediaController@fileUpload');

        Route::post('/delete', 'MediaController@deleteimage')->middleware('CheckIfAllowed');

        Route::get('/optimize', 'MediaController@optimizeimages');

        Route::get('/detail/{id}', 'MediaController@detailimage')->middleware('CheckIfAllowed');

        Route::post('/refresh', 'MediaController@refresh');

        Route::post('/gallery', 'MediaController@gallery');

        Route::post('/loadmore', 'MediaController@loadmore');

        Route::post('/regenerateimage', 'MediaController@regenerateimage')->middleware('CheckIfAllowed');

    });

    Route::group(['prefix' => 'admin/theme', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/setting', 'ThemeController@index');
        Route::get('/setting/{id}', 'ThemeController@moveToBanners');
        Route::get('/setting/carousals/{id}', 'ThemeController@moveToSliders');
        Route::post('setting/set', 'ThemeController@set');
        Route::post('setting/setPages', 'ThemeController@setPages');
        Route::post('/setting/updatebanner', 'ThemeController@updatebanner');
        Route::post('/setting/carousals/updateslider', 'ThemeController@updateslider');
        Route::post('/setting/addbanner', 'ThemeController@addbanner');
        Route::post('/reorder', 'ThemeController@reorder');
        Route::post('/setting/changestatus', 'ThemeController@changestatus');
        Route::post('/setting/fetchlanguages', 'LanguageController@fetchlanguages')->middleware('CheckIfAllowed');

    });

    Route::group(['prefix' => 'admin/mobile-slider', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/filter', 'MobileSliderController@filter');
        Route::get('/display', 'MobileSliderController@index');
        Route::get('/add', 'MobileSliderController@add');
        Route::post('/add', 'MobileSliderController@insert');
        Route::get('/edit/{id}', 'MobileSliderController@edit');
        Route::post('/update', 'MobileSliderController@update');
        Route::post('/delete', 'MobileSliderController@delete');
    });

    // Category

    Route::group(['prefix' => 'admin/category', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/list', 'CategoriesController@list')->middleware('CheckIfAllowed');

        Route::get('/edit/{id}', 'CategoriesController@edit')->middleware('CheckIfAllowed');

        Route::post('/ajax', 'CategoriesController@ajax')->middleware('CheckIfAllowed');

        Route::post('/showchildren/{ID}/{parent}', 'CategoriesController@showChildren')->middleware('CheckIfAllowed');

        Route::post('/create', 'CategoriesController@insert')->middleware('CheckIfAllowed');

        Route::post('/change_lang', 'CategoriesController@changeLang')->middleware('CheckIfAllowed');

        Route::post('/update/', 'CategoriesController@update')->middleware('CheckIfAllowed');
        Route::post('/delete/', 'CategoriesController@delete')->middleware('CheckIfAllowed');

    });


    // Deals

    Route::group(['prefix' => 'admin/deals', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/list', 'CategoriesController@list')->middleware('CheckIfAllowed');

        Route::get('/edit/{id}', 'CategoriesController@edit')->middleware('CheckIfAllowed');
        
        Route::post('/ajax', 'CategoriesController@ajax')->middleware('CheckIfAllowed');

        Route::post('/showchildren/{ID}/{parent}', 'CategoriesController@showChildren')->middleware('CheckIfAllowed');

        Route::post('/create', 'CategoriesController@insert')->middleware('CheckIfAllowed');

        Route::post('/update/', 'CategoriesController@update')->middleware('CheckIfAllowed');

        Route::post('/delete/', 'CategoriesController@delete')->middleware('CheckIfAllowed');
    });

    // Brand

    Route::group(['prefix' => 'admin/brand', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/list/', 'BrandsController@list')->middleware('CheckIfAllowed');

        Route::get('/list/{cat}/', 'BrandsController@list')->middleware('CheckIfAllowed');
        
        Route::get('/edit/{id}/', 'BrandsController@edit')->middleware('CheckIfAllowed');

        Route::post('/update/', 'BrandsController@update')->middleware('CheckIfAllowed');
        
        Route::post('/delete/', 'BrandsController@delete')->middleware('CheckIfAllowed');

        Route::post('/create', 'BrandsController@insert')->middleware('CheckIfAllowed');

        Route::post('/ajax', 'BrandsController@ajax')->middleware('CheckIfAllowed');

    });


    // Attributes

    Route::group(['prefix' => 'admin/attribute', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/list/', 'AttributeController@list')->middleware('CheckIfAllowed');

        Route::get('/list/{cat}', 'AttributeController@list')->middleware('CheckIfAllowed');

        Route::post('/create', 'AttributeController@insert')->middleware('CheckIfAllowed');

        Route::post('/update', 'AttributeController@update')->middleware('CheckIfAllowed');
        
        Route::post('/delete', 'AttributeController@delete')->middleware('CheckIfAllowed');

        Route::get('/values/{ID}', 'AttributeController@values')->middleware('CheckIfAllowed');
        
        Route::get('value/edit/{ID}', 'AttributeController@ValueEdit')->middleware('CheckIfAllowed');
        
        Route::post('value/update', 'AttributeController@updateValue')->middleware('CheckIfAllowed');

        Route::post('value/delete', 'AttributeController@deleteValue')->middleware('CheckIfAllowed');
        
        Route::get('/edit/{ID}', 'AttributeController@edit')->middleware('CheckIfAllowed');
        
        Route::post('value/change_lang', 'AttributeController@changeValueLang')->middleware('CheckIfAllowed');

        Route::post('/change_lang', 'AttributeController@changeLang')->middleware('CheckIfAllowed');

        Route::post('/create/value', 'AttributeController@insertValue')->middleware('CheckIfAllowed');

        Route::post('/ajax', 'AttributeController@ajax')->middleware('CheckIfAllowed');

    });


    Route::group(['prefix' => 'admin/currencies', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/display', 'CurrencyController@display')->middleware('CheckIfAllowed');
        Route::get('/add', 'CurrencyController@add')->middleware('CheckIfAllowed');
        Route::post('/add', 'CurrencyController@insert')->middleware('CheckIfAllowed');
        Route::get('/edit/{id}', 'CurrencyController@edit')->middleware('CheckIfAllowed');
        Route::get('/edit/warning/{id}', 'CurrencyController@warningedit')->middleware('CheckIfAllowed');
        Route::post('/update', 'CurrencyController@update')->middleware('CheckIfAllowed');
        Route::post('/delete', 'CurrencyController@delete')->middleware('CheckIfAllowed');

        Route::get('/display-ajax', 'CurrencyController@getCurrencies')->middleware('CheckIfAllowed');

    });


// ========================================= EOMMERCE ROUTES ===============================================//


    //Product Routes

    Route::group(['prefix' => 'admin/product', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('list', 'ProductsController@view')->middleware('CheckIfAllowedVendor');

        Route::get('import', 'ProductsController@import')->middleware('CheckIfAllowedVendor');

        Route::post('import', 'ProductsController@importData')->middleware('CheckIfAllowedVendor');

        Route::get('add', 'ProductsController@add')->middleware('CheckIfAllowedVendor');

        Route::post('create', 'ProductsController@create')->middleware('CheckIfAllowedVendor');

        Route::get('/edit/{ID}/', 'ProductsController@edit')->middleware('CheckIfAllowedVendor');

        Route::post('change_lang', 'ProductsController@changeLang');

        Route::post('/update/', 'ProductsController@update')->middleware('CheckIfAllowedVendor');

        Route::post('/delete', 'ProductsController@delete')->middleware('CheckIfAllowedVendor');

        Route::post('search', 'ProductsController@search')->middleware('CheckIfAllowedVendor');

        Route::get('variable', 'ProductsController@variable')->middleware('CheckIfAllowedVendor');

        Route::get('inventory/', 'ProductsController@inventory')->middleware('CheckIfAllowedVendor');
                Route::get('/inventory/inventory-ajax', 'ProductsController@getInventoryAjax')->middleware('CheckIfAllowedVendor');

        Route::get('inventory/edit/{id}', 'ProductsController@inventoryEdit')->middleware('CheckIfAllowedVendor');

        Route::post('inventory/update/', 'ProductsController@inventoryUpdate')->middleware('CheckIfAllowedVendor');
        
        Route::post('attribute/search', 'ProductsController@searchAttrs')->middleware('CheckIfAllowedVendor');

        Route::post('getvariations', 'ProductsController@getVariations')->middleware('CheckIfAllowedVendor');
        
        Route::post('assign-attrs', 'ProductsController@assignAttrs')->middleware('CheckIfAllowedVendor');

        Route::post('get-attrs', 'ProductsController@getAttrs')->middleware('CheckIfAllowedVendor');

        Route::post('values/search', 'ProductsController@searchValues')->middleware('CheckIfAllowedVendor');

        Route::post('save-values', 'ProductsController@saveValues')->middleware('CheckIfAllowedVendor');

        Route::post('add-variation', 'ProductsController@addVariation')->middleware('CheckIfAllowedVendor');
        
        Route::post('removevar', 'ProductsController@removeVariation')->middleware('CheckIfAllowedVendor');

        Route::post('create-variation', 'ProductsController@createVariation')->middleware('CheckIfAllowedVendor');

    });


    //Pages Routes
    
    Route::group(['prefix' => 'admin/page', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('list', 'PagesController@webpages')->middleware('CheckIfAllowed');

        Route::get('add', 'PagesController@addwebpage')->middleware('CheckIfAllowed');

        Route::post('create', 'PagesController@addnewwebpage')->middleware('CheckIfAllowed');

        Route::get('edit/{id}', 'PagesController@editwebpage')->middleware('CheckIfAllowed');

        Route::post('update', 'PagesController@updatewebpage')->middleware('CheckIfAllowed');

        Route::post('change_lang', 'PagesController@changeLang')->middleware('CheckIfAllowed');

       Route::post('delete/{id?}', 'PagesController@deletepage');
       Route::get('ajax', 'PagesController@getPagesAjax')->name('admin.pages.ajax');

    });



    Route::group(['prefix' => 'admin/', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        // Reviews

        Route::get('/reviews/', 'ReviewsController@view')->middleware('CheckIfAllowed');
        
        Route::get('/reviews/edit/{ID}', 'ReviewsController@edit')->middleware('CheckIfAllowed');
        
        Route::post('/reviews/update', 'ReviewsController@update')->middleware('CheckIfAllowed');
        
        Route::post('/reviews/delete', 'ReviewsController@delete')->middleware('CheckIfAllowed');


        // Comments

        Route::get('/questions/', 'ReviewsController@viewQuestion')->middleware('CheckIfAllowed');
        
        Route::get('/questions/edit/{ID}', 'ReviewsController@editQuestion')->middleware('CheckIfAllowed');
        
        Route::post('/questions/update', 'ReviewsController@updateQuestion')->middleware('CheckIfAllowed');
        
        Route::post('/questions/delete', 'ReviewsController@deleteQuestion')->middleware('CheckIfAllowed');

        //Post Type Routes

        Route::get('/list/{post_type}/', 'PostsController@view')->middleware('CheckIfAllowed');
Route::get('posts-ajax', 'PostsController@getPostTypes');
        Route::get('/customer-wallet-history', 'CustomersController@wallet')->middleware('CheckIfAllowed');
        Route::get('/customer-wallet-ajax', 'CustomersController@walletAjax')->middleware('CheckIfAllowed');

        Route::get('/add/{post_type}/', 'PostsController@add')->middleware('CheckIfAllowed');

        Route::post('/create/{post_type}/', 'PostsController@create')->middleware('CheckIfAllowed');

        Route::post('posts/change_lang', 'PostsController@changeLang');

        Route::get('/edit/{post_type}/{post_id}/', 'PostsController@edit')->middleware('CheckIfAllowed');

        Route::post('/update/{post_id}/', 'PostsController@update')->middleware('CheckIfAllowed');

        Route::post('/deletepost', 'PostsController@delete')->middleware('CheckIfAllowed');


        //Taxonomy Routes

        Route::get('/taxonomy/{slug}/', 'TaxonomyController@view')->middleware('CheckIfAllowed');

        Route::post('/taxonomy/create/', 'TaxonomyController@create')->middleware('CheckIfAllowed');

        Route::post('/taxonomy/delete/', 'TaxonomyController@delete')->middleware('CheckIfAllowed');

        Route::get('/taxonomy/edit/{id}', 'TaxonomyController@edit')->middleware('CheckIfAllowed');

        Route::post('/taxonomy/change_lang', 'TaxonomyController@changeLang')->middleware('CheckIfAllowed');

        Route::post('/taxonomy/update/', 'TaxonomyController@update')->middleware('CheckIfAllowed');

        

        //Reports Routes

        Route::get('/reports/low-stock/', 'ReportsController@lowStock')->middleware('CheckIfAllowed');
        Route::get('/reports/low-stock-ajax/', 'ReportsController@getLowStockProducts')->middleware('CheckIfAllowedVendor');
        Route::get('/reviews-ajax/', 'ReviewsController@getReviewsAjax')->middleware('CheckIfAllowedVendor');

        Route::get('/reports/out-stock/', 'ReportsController@outStock')->middleware('CheckIfAllowed');
        Route::get('/reports/out-stock-ajax/', 'ReportsController@getOutStockProducts')->middleware('CheckIfAllowedVendor');

        Route::get('/reports/customers/', 'ReportsController@customersTotal')->middleware('CheckIfAllowed');
        Route::get('/reports/customers-total-ajax/', 'ReportsController@getCustomersTotal')->middleware('CheckIfAllowed');

        Route::get('/reports/sales-report/', 'ReportsController@salesReport')->middleware('CheckIfAllowed');
        Route::get('/reports/sales-report-ajax/', 'ReportsController@getSalesReport')->middleware('CheckIfAllowed');

        // Lables

        Route::get('/listingAppLabels', 'AppLabelsController@listingAppLabels')->middleware('CheckIfAllowed');
        Route::get('/addappkey', 'AppLabelsController@addappkey')->middleware('CheckIfAllowed');
        Route::post('/addNewAppLabel', 'AppLabelsController@addNewAppLabel')->middleware('CheckIfAllowed');
        Route::get('/editAppLabel/{id}', 'AppLabelsController@editAppLabel')->middleware('CheckIfAllowed');
        Route::post('/updateAppLabel/', 'AppLabelsController@updateAppLabel');
        Route::get('/applabel', 'AppLabelsController@manageAppLabel');

    });


   // Order Routes

    Route::group(['prefix' => 'admin/orders', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/display', 'OrdersController@display')->middleware('CheckIfAllowedVendor');
        Route::get('/orders-ajax', 'OrdersController@getOrdersAjax')->middleware('CheckIfAllowedVendor');

        Route::post('/returntowallet/', 'OrdersController@returnToWallet')->middleware('CheckIfAllowedVendor');
        
        Route::post('/update', 'OrdersController@update')->middleware('CheckIfAllowedVendor');

        Route::get('/create', 'OrdersController@add')->middleware('CheckIfAllowedVendor');
        
        Route::post('/create', 'OrdersController@insert')->middleware('CheckIfAllowedVendor');

        Route::get('/reports/{period}', 'OrdersController@report')->middleware('CheckIfAllowedVendor');

        Route::get('/edit/{id}', 'OrdersController@edit')->middleware('CheckIfAllowedVendor');

        Route::post('/delete', 'OrdersController@delete')->middleware('CheckIfAllowedVendor');

        Route::post('/update-order-status', 'OrdersController@update_order_status')->middleware('CheckIfAllowedVendor');

        Route::get('/invoice/{id}', 'OrdersController@print')->middleware('CheckIfAllowedVendor');
                        Route::get('/default-addresses', 'OrdersController@getDefaultAddress')->name('default-addresses');

    });


    Route::group(['prefix' => 'admin/admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/profile', 'AdminController@profile')->middleware('CheckIfAllowed');

        Route::post('/update', 'AdminController@update')->middleware('CheckIfAllowed');

        Route::post('/updatepassword', 'AdminController@updatepassword')->middleware('CheckIfAllowed');
        
        Route::post('/delete', 'AdminController@delete')->middleware('CheckIfAllowed');
    });


    // Coupons

    Route::group(['prefix' => 'admin/coupons', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/display', 'CouponsController@display')->middleware('CheckIfAllowed');
        Route::get('/coupons-ajax', 'CouponsController@getCouponsAjax')->middleware('CheckIfAllowedVendor');

        Route::get('/add', 'CouponsController@add')->middleware('CheckIfAllowed');

        Route::post('/add', 'CouponsController@insert')->middleware('CheckIfAllowed');

        Route::get('/edit/{id}', 'CouponsController@edit')->middleware('CheckIfAllowed');

        Route::post('/update', 'CouponsController@update')->middleware('CheckIfAllowed');

        Route::post('/delete', 'CouponsController@delete')->middleware('CheckIfAllowed');

        Route::get('/filter', 'CouponsController@filter')->middleware('CheckIfAllowed');

    });


    Route::group(['prefix' => 'admin/reviews', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/display', 'ProductController@reviews')->middleware('view_reviews');
        Route::get('/edit/{id}/{status}', 'ProductController@editreviews')->middleware('edit_reviews');

    });


    //customers
    
    Route::group(['prefix' => 'admin/customers', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/display', 'CustomersController@display')->middleware('CheckIfAllowed');
        Route::get('/customers-ajax', 'CustomersController@getCustomersAjax')->middleware('CheckIfAllowed');


        
        Route::get('/referrals', 'CustomersController@referrals')->middleware('CheckIfAllowed');

        Route::get('/add', 'CustomersController@add')->middleware('CheckIfAllowed');

        Route::post('/add', 'CustomersController@insert')->middleware('CheckIfAllowed');

        Route::get('/edit/{id}', 'CustomersController@edit')->middleware('CheckIfAllowed');

        Route::post('/update', 'CustomersController@update')->middleware('CheckIfAllowed');

        Route::post('/delete', 'CustomersController@delete')->middleware('CheckIfAllowed');

        Route::get('/filter', 'CustomersController@filter')->middleware('CheckIfAllowed');
        Route::post('/update-active-status/{id}', 'CustomersController@updateCustomerStatus')->name('update-customer-status')->middleware('CheckIfAllowed');

    });
    //Vendors

    Route::group(['prefix' => 'admin/vendors', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('/display', 'VendorsController@display')->middleware('CheckIfAllowed');

        Route::get('/add', 'VendorsController@add')->middleware('CheckIfAllowed');

        Route::post('/add', 'VendorsController@insert')->middleware('CheckIfAllowed');

        Route::get('/edit/{id}', 'VendorsController@edit')->middleware('CheckIfAllowed');

        Route::post('/update', 'VendorsController@update')->middleware('CheckIfAllowed');

        Route::post('/delete', 'VendorsController@delete')->middleware('CheckIfAllowed');

        Route::get('/filter', 'VendorsController@filter')->middleware('view_customer');
        Route::get('/ajax', 'VendorsController@getVendorsAjax')->middleware('CheckIfAllowed');

    });

    Route::group(['prefix' => 'admin/stores', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/display', 'VendorsController@storesListing');
        Route::get('status/update/{id}', 'VendorsController@updateStatus');
    });
    
    Route::group(['prefix' => 'admin/countries', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/filter', 'CountriesController@filter');
        Route::get('/display', 'CountriesController@index');
        Route::get('/add', 'CountriesController@add');
        Route::post('/add', 'CountriesController@insert');
        Route::get('/edit/{id}', 'CountriesController@edit');
        Route::post('/update', 'CountriesController@update');
        Route::post('/delete', 'CountriesController@delete');
    });

    Route::group(['prefix' => 'admin/zones', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/display', 'ZonesController@index');
        Route::get('/filter', 'ZonesController@filter');
        Route::get('/add', 'ZonesController@add');
        Route::post('/add', 'ZonesController@insert');
        Route::get('/edit/{id}', 'ZonesController@edit');
        Route::post('/update', 'ZonesController@update');
        Route::post('/delete', 'ZonesController@delete');
    });

    Route::group(['prefix' => 'admin/tax', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::group(['prefix' => '/taxclass'], function () {
            Route::get('/filter', 'TaxController@filtertaxclass');
            Route::get('/display', 'TaxController@taxindex');
            Route::get('/add', 'TaxController@addtaxclass');
            Route::post('/add', 'TaxController@inserttaxclass');
            Route::get('/edit/{id}', 'TaxController@edittaxclass');
            Route::post('/update', 'TaxController@updatetaxclass');
            Route::post('/delete', 'TaxController@deletetaxclass');
        });

        Route::group(['prefix' => '/taxrates'], function () {
            Route::get('/display', 'TaxController@displaytaxrates');
            Route::get('/filter', 'TaxController@filtertaxrates');
            Route::get('/add', 'TaxController@addtaxrate');
            Route::post('/add', 'TaxController@inserttaxrate');
            Route::get('/edit/{id}', 'TaxController@edittaxrate');
            Route::post('/update', 'TaxController@updatetaxrate');
            Route::post('/delete', 'TaxController@deletetaxrate');
        });

    });

    Route::group(['prefix' => 'admin/shippingmethods', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        //shipping setting
        Route::get('/display', 'ShippingMethodsController@display')->middleware('CheckIfAllowed');
        Route::get('/upsShipping', 'ShippingMethodsController@upsShipping')->middleware('CheckIfAllowed');
        Route::post('/updateupsshipping', 'ShippingMethodsController@updateupsshipping')->middleware('CheckIfAllowed');
        Route::get('/flateRate', 'ShippingMethodsController@flateRate')->middleware('CheckIfAllowed');
        Route::post('/updateflaterate', 'ShippingMethodsController@updateflaterate')->middleware('CheckIfAllowed');
        Route::post('/defaultShippingMethod', 'ShippingMethodsController@defaultShippingMethod')->middleware('CheckIfAllowed');
        Route::get('/detail/{table_name}', 'ShippingMethodsController@detail')->middleware('CheckIfAllowed');
        Route::post('/update', 'ShippingMethodsController@update')->middleware('CheckIfAllowed');

        Route::get('/shppingbyweight', 'ShippingByWeightController@shppingbyweight')->middleware('CheckIfAllowed');
        Route::post('/updateShppingWeightPrice', 'ShippingByWeightController@updateShppingWeightPrice')->middleware('CheckIfAllowed');

    });

    Route::group(['prefix' => 'admin/paymentmethods', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
        Route::get('/index', 'PaymentMethodsController@index')->middleware('CheckIfAllowed');
        Route::get('/display/{id}', 'PaymentMethodsController@display')->middleware('CheckIfAllowed');
        Route::post('/update', 'PaymentMethodsController@update')->middleware('CheckIfAllowed');
        Route::post('/active', 'PaymentMethodsController@active')->middleware('CheckIfAllowed');
    });


    Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {

        Route::get('abandonedcart', 'AbandonedCartController@list')->middleware('CheckIfAllowed');
        Route::get('/abandonedcart/ajax', 'AbandonedCartController@getAbandonedCarts')->middleware('CheckIfAllowed');
        Route::get('abandonedcart/email/{email}', 'AbandonedCartController@email')->middleware('CheckIfAllowed');
        
        Route::get('/statscustomers', 'ReportsController@statsCustomers')->middleware('CheckIfAllowed');
        Route::get('/statsproductspurchased', 'ReportsController@statsProductsPurchased')->middleware('CheckIfAllowed');
        Route::get('/statsproductsliked', 'ReportsController@statsProductsLiked')->middleware('CheckIfAllowed');
        Route::get('/outofstock', 'ReportsController@outofstock')->middleware('CheckIfAllowed');
        Route::get('/lowinstock', 'ReportsController@lowinstock')->middleware('CheckIfAllowed');
        Route::get('/stockin', 'ReportsController@stockin')->middleware('CheckIfAllowed');
        Route::post('/productSaleReport', 'ReportsController@productSaleReport')->middleware('CheckIfAllowed');
        Route::get('/custom-porducts-report', 'ReportsController@customproductSaleReport')->middleware('CheckIfAllowed');
        Route::post('/custom-porducts-report', 'ReportsController@customproductSaleReport');

        Route::get('/transactions-report', 'ReportsController@TransactionsReport')->middleware('CheckIfAllowed');
        Route::post('/transactions-report', 'ReportsController@TransactionsReport');

            //Menu Routes

        Route::post('menuposition', 'MenusController@menuposition')->middleware('CheckIfAllowed');
        
        Route::get('/mega-menu', 'MenusController@megaMenu')->middleware('CheckIfAllowed');
        
        Route::get('/megamenu/edit/{id}', 'MenusController@megaEdit')->middleware('CheckIfAllowed');
        
        Route::post('/megamenu/update/', 'MenusController@megaUpdate')->middleware('CheckIfAllowed');

        Route::get('/megamenu/add/', 'MenusController@megaAdd')->middleware('CheckIfAllowed');

        Route::post('/megamenu/create/', 'MenusController@megaCreate')->middleware('CheckIfAllowed');
        
        Route::post('/megamenu/delete/', 'MenusController@deleteMega')->middleware('CheckIfAllowed');

        Route::get('/menus', 'MenusController@menus')->middleware('CheckIfAllowed');

        Route::get('/addmenus', 'MenusController@addmenus')->middleware('CheckIfAllowed');

        Route::post('/addnewmenu', 'MenusController@addnewmenu')->middleware('CheckIfAllowed');
        
        Route::post('/menu/change_lang', 'MenusController@changeLang')->middleware('CheckIfAllowed');

        Route::get('/editmenu/{id}', 'MenusController@editmenu')->middleware('CheckIfAllowed');

        Route::post('/updatemenu', 'MenusController@updatemenu')->middleware('CheckIfAllowed');

        Route::get('/deletemenu/{id}', 'MenusController@deletemenu')->middleware('CheckIfAllowed');

        Route::post('/deletemenu', 'MenusController@deletemenu')->middleware('CheckIfAllowed');


        Route::get('/catalogmenu', 'MenusController@catalogmenu')->middleware('CheckIfAllowed');


        // Settings

        Route::get('/setting', 'SiteSettingController@webSettings')->middleware('CheckIfAllowed');
                Route::get('/popup', 'SiteSettingController@popup')->middleware('CheckIfAllowed');

        Route::get('/home-content', 'SiteSettingController@homeContent')->middleware('CheckIfAllowed');
        Route::get('/app-config', 'SiteSettingController@appConfig')->middleware('view_web_setting', 'website_routes');
        
        Route::post('/updateSetting', 'SiteSettingController@updateSetting')->middleware('CheckIfAllowed');

        
        // contact
        Route::get('/coupon-theme', 'AdminController@CouponTheme');
        Route::post('/coupon-theme-update', 'AdminController@CouponThemeUpdate');

        // Route::get('/seo', 'SiteSettingController@seo')->middleware('CheckIfAllowed');

        Route::get('/customstyle', 'SiteSettingController@customstyle')->middleware('CheckIfAllowed');

        Route::post('/updateWebTheme', 'SiteSettingController@updateWebTheme')->middleware('CheckIfAllowed');

        Route::get('/instafeed', 'SiteSettingController@instafeed')->middleware('CheckIfAllowed');





        Route::get('/orderstatus', 'SiteSettingController@orderstatus')->middleware('CheckIfAllowed');
        Route::get('/addorderstatus', 'SiteSettingController@addorderstatus')->middleware('CheckIfAllowed');
        Route::post('/addNewOrderStatus', 'SiteSettingController@addNewOrderStatus')->middleware('CheckIfAllowed');
        Route::get('/editorderstatus/{id}', 'SiteSettingController@editorderstatus')->middleware('CheckIfAllowed');
        Route::post('/updateOrderStatus', 'SiteSettingController@updateOrderStatus')->middleware('CheckIfAllowed');
        Route::post('/deleteOrderStatus', 'SiteSettingController@deleteOrderStatus')->middleware('CheckIfAllowed');

        Route::get('/facebooksettings', 'SiteSettingController@facebookSettings')->middleware('CheckIfAllowed');
        Route::get('/instasettings', 'SiteSettingController@instasettings')->middleware('CheckIfAllowed');
        Route::get('/googlesettings', 'SiteSettingController@googleSettings')->middleware('CheckIfAllowed');
        //pushNotification
        Route::get('/pushnotification', 'SiteSettingController@pushNotification')->middleware('CheckIfAllowed');
        Route::get('/alertsetting', 'SiteSettingController@alertSetting')->middleware('CheckIfAllowed');
        Route::post('/updateAlertSetting', 'SiteSettingController@updateAlertSetting');

        //admin managements
        Route::get('/admins', 'AdminController@admins')->middleware('CheckIfAllowed');
                Route::get('/admins-ajax', 'AdminController@getAdmins')->middleware('CheckIfAllowed');

        Route::get('/editaccess/{id}', 'AdminController@editAccess')->middleware('CheckIfAllowed');

        Route::post('/updateaccess/{id}', 'AdminController@updateAccess')->middleware('CheckIfAllowed');

        Route::get('/addadmins', 'AdminController@addadmins')->middleware('CheckIfAllowed');
        
        Route::post('/addnewadmin', 'AdminController@addnewadmin')->middleware('CheckIfAllowed');
        
        Route::get('/editadmin/{id}', 'AdminController@editadmin')->middleware('CheckIfAllowed');
        
        Route::post('/updateadmin', 'AdminController@updateadmin')->middleware('CheckIfAllowed');
        
        Route::post('/deleteadmin', 'AdminController@deleteadmin')->middleware('CheckIfAllowed');

        //admin managements
        Route::get('/manageroles', 'AdminController@manageroles')->middleware('CheckIfAllowed');
        Route::get('/addrole/{id}', 'AdminController@addrole')->middleware('CheckIfAllowed');


        Route::post('/addnewroles', 'AdminController@addnewroles')->middleware('CheckIfAllowed');
        Route::get('/addadmintype', 'AdminController@addadmintype')->middleware('CheckIfAllowed');
        Route::post('/addnewtype', 'AdminController@addnewtype')->middleware('CheckIfAllowed');
        Route::get('/editadmintype/{id}', 'AdminController@editadmintype')->middleware('CheckIfAllowed');
        Route::post('/updatetype', 'AdminController@updatetype')->middleware('CheckIfAllowed');
        Route::post('/deleteadmintype', 'AdminController@deleteadmintype')->middleware('CheckIfAllowed');

        Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    });

Route::group(['prefix' => 'admin/managements', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/merge', 'ManagementsController@merge')->middleware('CheckIfAllowed');
    Route::get('/backup', 'ManagementsController@backup')->middleware('CheckIfAllowed');
    Route::post('/take_backup', 'ManagementsController@take_backup')->middleware('CheckIfAllowed');
    Route::get('/import', 'ManagementsController@import')->middleware('CheckIfAllowed');
    Route::post('/importdata', 'ManagementsController@importdata')->middleware('CheckIfAllowed');
    Route::post('/mergecontent', 'ManagementsController@mergecontent')->middleware('CheckIfAllowed');
    Route::get('/updater', 'ManagementsController@updater')->middleware('CheckIfAllowed');
    Route::post('/checkpassword', 'ManagementsController@checkpassword')->middleware('CheckIfAllowed');
    Route::post('/updatercontent', 'ManagementsController@updatercontent')->middleware('CheckIfAllowed');
});

Route::group(['prefix' => 'admin/seo', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/display', 'SeoController@display')->middleware('CheckIfAllowed');
    Route::get('/add', 'SeoController@add')->middleware('CheckIfAllowed');
    Route::post('/add', 'SeoController@insert')->middleware('CheckIfAllowed');
    Route::get('/edit/{id}', 'SeoController@edit')->middleware('CheckIfAllowed');
    Route::post('/update', 'SeoController@update')->middleware('CheckIfAllowed');
    Route::post('/delete', 'SeoController@delete')->middleware('CheckIfAllowed');
    Route::get('/filter', 'SeoController@filter')->middleware('CheckIfAllowed');
});
});

<?php
Route::any('test',function (){
    return view('home');

});


Route::post('/create-account','HomeController@createAccount')->name('create_account');

Route::any('paymentTest',"test\TestController@index");
Route::any('payfort',"test\TestController@payfort");
Route::any('payment',"test\TestController@payment");

Route::any('payfortFinish',"PayfortController@finish");
Route::any('payfortSave',"PayfortController@save")->name('payfortSave');
Route::any('payfortToken',"PayfortController@getToken");
Route::any('payfortOperation',"PayfortController@getOperation");
Route::any('payfortSaveOrder',"PayfortController@getOrderSession");

Route::get('image/{type}/{filename}', 'ImageController@index')
    ->where('type', 'manufacturer|brand|product|module|category')
    ->name('image');
Route::get('images/{type}/{filename}', 'ImageController@index')
    ->where('type', 'manufacturer|brand|product|module|category')
    ->name('images');

Route::get('thumb/{type}/{w}x{h}/{filename}', 'ImageController@thumb')
    ->where('w', '5|39|50|64|100|150|300|400|275|250|768|84')
    ->where('h', '5|39|50|64|100|150|300|280|180|250|988|120')
    ->where('type', 'manufacturer|brand|module|product|category')
    ->name('thumb');


Route::group([
    'prefix'    => 'big-boss',
    'namespace' => 'Admin',
//     'as'        => 'admin',
],
    function () {

    Route::get('/login','AdminLoginController@showAdminLoginForm')->name('admin.login');
    Route::post('/login','AdminLoginController@adminLogin');
    Route::get('/logout','AdminLoginController@adminLogout')->name('admin.logout');


	Route::group([
   		'middleware' => ['admin'],
        'as' => 'admin.',
	], function(){

        Route::post('/approve-return','ReturnOrdersController@approve_return');
        Route::post('/disapprove-return','ReturnOrdersController@disapprove_return');
        Route::get('/','HomeController@index')->name('home');
        Route::get('/logs','LogsController@index')->name('logs');
	    Route::resource('/page','PagesController');
        Route::resource('/permissions','PermissionsController');
        Route::resource('/permgroups','PermissionsGroupsController');
	    Route::resource('/roles','RolesController');
	    Route::resource('/users','AdminUsersController');


        Route::resource('/return_reasons','ReturnReasonController');
        Route::resource('/returns', 'ReturnOrdersController');
        Route::resource('/withdraws', 'WithdrawController');

        Route::get('/categories/export','CategoriesController@export')->name('categories.export');
        Route::post('/categories/import','CategoriesController@import')->name('categories.import');
        Route::resource('/categories','CategoriesController');


	    Route::resource('/dealsection','DealSectionController');
        Route::get('/dealsection/get_products/{id}','DealSectionController@get_products');

	    Route::get('/brands/export','BrandsController@export')->name('brands.export');
        Route::post('/brands/import','BrandsController@import')->name('brands.import');
        Route::resource('/brands','BrandsController');

        Route::resource('/customers','CustomersController');
        Route::resource('/subscribers','SubscribersController');

        Route::get('/manufacturers/export','ManufacturersController@export')->name('manufacturers.export');
        Route::post('/manufacturers/import','ManufacturersController@import')->name('manufacturers.import');
	    Route::resource('/manufacturers','ManufacturersController');

        Route::resource('/cupons','CuponsController');
        Route::resource('/promotions','PromotionsController');

        Route::get('bundles/products','BundlesController@products')->name('bundles.products');
        Route::post('bundles/data','BundlesController@data')->name('bundles.data');
        Route::resource('bundles','BundlesController');
        Route::get('bundles/activation/{id}','BundlesController@activation')->name('bundles.active');
        Route::get('product/activation/{id}','ProductsController@activation')->name('products.active');
        

        Route::get('combo/products','ComboController@products')->name('combo.products');
        Route::get('combo/categories','ComboController@categories')->name('combo.categories');
        Route::post('combo/data','ComboController@data')->name('combo.data');
        Route::resource('combo','ComboController');

        Route::get('/products/export','ProductsController@export')->name('products.export');
        Route::get('/products/import','ProductsController@importShow')->name('products.import.show');
        Route::post('/products/import','ProductsController@import')->name('products.import');
        Route::post('/products/data/{kind?}','ProductsController@data')->name('products.data');
        Route::get('/products/{id}/enddeal','ProductsController@enddeal')->name('products.enddeal');
        Route::get('/products/onsale','ProductsController@onSale')->name('products.onsale');

        Route::get('/products/hot','ProductsController@onHot')->name('products.hot');

        Route::get('/products/combo','ProductsController@comboProducts')->name('products.combo');

        Route::resource('/products','ProductsController');
        Route::post('/attributes-product', 'ProductsController@getProductAttributesAjax')->name('product.attributes');
        Route::post('/attributes-current-product', 'ProductsController@getCurrentProductAttributesAjax')->name('product.attributes');
        Route::get('/pattributes', 'ProductsController@getProductAttributes')->name('products.attributes');
        Route::get('/product/{id}','ProductsController@findone');
        Route::get('inventories/{inventory}/products/create', 'InventoryProductsController@create')->name('inventory.products.create');
        Route::post('inventories/{inventory}/products', 'InventoryProductsController@store')->name('inventory.products.store');
        Route::delete('inventories/{inventory}/products/{inventory_product}', 'InventoryProductsController@destroy')->name('inventory.products.destroy');
        Route::get('inventories/{inventory}/products', 'InventoryProductsController@index')->name('inventory.products');
        Route::resource('inventories', 'InventoriesController');

        Route::post('/translations/data','TranslationsController@data')->name('translations.data');
        Route::resource('/translations','TranslationsController');
        Route::get('/modules/{id}/active/{active}','ModulesController@active')->name('modules.active');
        Route::post('/modules/order','ModulesController@saveOrder')->name('modules.order');
        Route::resource('/modules','ModulesController');
        Route::resource('/attributes','AttributesController');
        Route::resource('/attrgroups','AttributeGroupsController');
        Route::resource('/options','OptionsController');
        Route::post('/options/values','OptionsController@getValuesByOptionId')->name('options.values');
        Route::get('/main_setting','SettingController@main_setting')->name('setting.main_setting');
        Route::post('/main_setting','SettingController@main_setting_post')->name('setting.main_setting_post');
        Route::resource('/setting','SettingController');
        Route::resource('/packages','PackagesController');
        Route::resource('countries', 'CountriesController');
        Route::post('/states/data','StatesController@data')->name('states.data');
        Route::resource('states', 'StatesController');

        Route::post('cities/data','CitiesController@data')->name('cities.data');
        Route::resource('cities', 'CitiesController');
        Route::post('locations/data','LocationsController@data')->name('locations.data');
        Route::resource('locations', 'LocationsController');
        Route::post('orders/{order}', 'OrdersController@save');
        Route::resource('orders', 'OrdersController');
        Route::get('cancelled_orders', 'OrdersController@cancelled_orders')->name('orders.cancelled');
        Route::get('show-bundle-order/{id}/{bundle_id}', 'OrdersController@show_bundle')->name('order.bundle.show');
        Route::post('transactions/data','TransactionController@data')->name('transactions.data');
        Route::resource('transactions', 'TransactionController');
        Route::post('reviews/data','ReviewsController@data')->name('reviews.data');
        // Route::resource('reviews', 'ReviewsController');
        Route::get('reviews','ReviewsController@index')->name('reviews.index');
        Route::get('reviews/approve','ReviewsController@approve')->name('reviews.approve');
        Route::get('reviews/disapprove','ReviewsController@disapprove')->name('reviews.disapprove');
        // reports
        Route::get('report/orders','ReportsController@ordersReportTable')->name('report.orders');
        Route::post('report/orders','ReportsController@ordersReportResults')->name('report.orders.results');
        Route::get('bulk_image_upload','BulkImagesController@index')->name('admin.images.index');
        Route::post('bulk_image_upload','BulkImagesController@store')->name('admin.images.post');

        // Points
        Route::post('points/data','PointController@data')->name('points.data');
        Route::resource('points', 'PointController');
        Route::post('points','PointController@index_post')->name('points.index_post');

        // Complaints
        Route::get('complaints/{user_id}','ComplaintController@chat');
        Route::post('complaints/{user_id}','ComplaintController@chat_store');
        Route::post('complaints/data','ComplaintController@data')->name('complaints.data');
        Route::resource('complaints', 'ComplaintController');

        // Shipping Routes
        Route::post('shipping_companies/data','ShippingCompanyController@data')->name('shipping-companies.data');
        Route::resource('shipping_companies', 'ShippingCompanyController');
        Route::post('shipping_zones/data','ShippingZoneController@data')->name('shipping-zones.data');
        Route::resource('shipping_zones', 'ShippingZoneController');
        Route::post('shipping_requests/data','ShippingRequestController@data')->name('shipping-requests.data');
        Route::resource('shipping_requests', 'ShippingRequestController');
        Route::get('shipping_requests/proccess/{id}','ShippingRequestController@proccess')->name('shipping_requests.proccess');
        Route::get('shipping_requests/delivered/{id}','ShippingRequestController@delivered')->name('shipping_requests.delivered');
        // Route::resource('orders/reports','AdminUsersController');

        // Shipping Request shipping-request/'+company+'/'+order+'/'+orderline
        Route::get('shipping-request/{company}/{order}/{orderline}','ShippingRequestController@check');

        //Periorty
        Route::get('priroty/','PriortyController@index')->name('priroty');
        Route::get('priroty/create','PriortyController@create');
        Route::post('priroty/store','PriortyController@store')->name('priorty.store');
        Route::get('priroty/edit/{id}','PriortyController@edit')->name('priorty.edit');
        Route::post('priroty/update/{id}','PriortyController@update')->name('priorty.update');
        Route::post('priroty/update-all','PriortyController@update_all')->name('priorty.updateall');
        Route::post('priroty/toggole','PriortyController@toggole')->name('priorty.toggole');

    });
});

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'as' => 'web.'
    ], function() {
    Route::get('/check_combo_price/{ids}/{combo_id}', 'ComboController@check_combo_price');
    Route::get('/category_filter/{id}','SearchController@category_filter');
    Route::get('/search_filter/{id}','SearchController@search_filter');
    Route::get('/add_to_compare/{id}','HomeController@compare');
    Route::get('/remove_from_compare/{id}','HomeController@remove_compare');
    Route::get('/','HomeController@new')->name('new');
    Route::get('/login','HomeController@login')->name('new');
    Route::get('/register','HomeController@register')->name('new.register');
    Route::get('/cancel_order/{id}','CheckoutController@cancel_order');
    Route::get('/order_update/{product}/{order}/{reason}/{bank_name}/{bank_number}','ReturnReasonController@return_request');
    Route::get('/get_cities/{country_id}','CheckoutController@get_cities')->name('new');
    // Route::get('/new/{page}/page', 'HomeController@page')->name('page');
    // Route::get('/new/{category}/c','SearchController@newIndex')->name('categories.products.search');

    // Route::get('/new/{category}/c','Website\SearchController@index')->name('new.categories.products.search');

    // facebook
    Route::get('login/facebook', 'Auth\SocialLoginController@facebookRedirectToProvider')->name('login.facebook');
    Route::get('login/facebook/callback', 'Auth\SocialLoginController@facebookHandleProviderCallback');

    // google
    Route::get('login/google', 'Auth\SocialLoginController@googleRedirectToProvider')->name('login.google');
    Route::get('login/google/callback', 'Auth\SocialLoginController@googleHandleProviderCallback');

    // twitter
    Route::get('login/twitter', 'Auth\SocialLoginController@twitterRedirectToProvider')->name('login.twitter');
    Route::get('login/twitter/callback', 'Auth\SocialLoginController@twitterHandleProviderCallback');
    Route::get('get-agree-terms','HomeController@get_agree_terms');


    Route::get('/old', 'HomeController@index');
    Route::get('/', 'HomeController@new')->name('home');

    Route::get('/allcategories', 'CategoryController@index');
    Route::post('/contact', 'ContactController@index')->name('contact');
    Route::get('/{page}/page', 'HomeController@page')->name('page');
    Route::get('/account/verify/show', 'VerificationController@verifyForm')->name('account.verify.show');
    Route::post('/account/verify', 'VerificationController@verify')->name('account.verify');
    Route::get('/account/verify/resend', 'VerificationController@resend')->name('account.verify.resend');

    // products
    Route::get('/{product}/p','ProductsController@show')->name('products.show');
    //Route::post('/{product}/p','ProductsController@write_review');

    Route::get('/{category}/c','SearchController@category')->name('categories.products.search');
    Route::post('/{category}/c','SearchController@category_filter')->name('categories.products.search');

    Route::get('/search', 'SearchController@index')->name('products.search');
    Route::get('/dealsection/{slug}', 'SearchController@dealsection')->name('products.search');
    Route::post('/product/rate', 'ReviewController@setRating')->name('products.rate');

    // wishlist
    Route::get('/wishlist','WishlistController@show')->name('wishlist.show');
    Route::get('/wishlist/store','WishlistController@store')->name('wishlist.store');
    Route::get('/wishlist/get','WishlistController@getWishlist')->name('wishlist.get');
    Route::get('/wishlist/delete','WishlistController@delete')->name('wishlist.delete');

    // Compare
    Route::get('/compare','HomeController@show_compare')->name('wishlist.show');

    // cart
    Route::get('/cart','CartController@show')->name('cart.show');
    Route::get('/buynow','CartController@buynow')->name('cart.buynow');
    Route::get('/cart/store','CartController@store')->name('cart.store');
    Route::get('/cart/get','CartController@getCart')->name('cart.get');
    Route::get('/cart/delete','CartController@delete')->name('cart.delete');
    Route::get('/cart/flush','CartController@deleteAll')->name('cart.flush');
    Route::get('/p/attribute/check','CartController@checkAttributes')->name('product.attribute.validate');

    // checkout
    Route::get('/checkout', 'CheckoutController@show')->name('checkout.show');
    Route::get('/order/history', 'CheckoutController@orderHistory')->name('order.history');
    Route::get('/order/history/{id}', 'CheckoutController@orderHistoryOrder')->name('order.history.order');
    Route::post('/order/history/{id}', 'ProductsController@write_review');
    Route::get('/order/success', 'CheckoutController@orderSuccess')->name('order.success');
    Route::post('/checkout', 'CheckoutController@checkout')->name('checkout.send');
    Route::get('/response', 'HomeController@response')->name('response.show');

    // cupon
    Route::get('/cupon/apply/{code}', 'CuponsController@applyCupon')->name('cupon.apply');

    // users
    Route::get('/user/profile/{id}', 'UsersController@showProfile')->name('user.profile');
    Route::post('/user/profile/', 'UsersController@updateProfile')->name('user.profile.update');
    Route::get('/user/points', 'PointController@index')->name('user.points.index');
    Route::get('/convert_points', 'PointController@convert_points')->name('user.points.convert_points');
    Route::get('/user/wallet', 'WalletController@index')->name('user.wallet.index');
    Route::get('/user/complaints', 'ComplaintController@index')->name('user.complaints.index');
    Route::post('/user/complaints', 'ComplaintController@store')->name('user.complaints.store');
    Route::get('/gmap/show/', 'HomeController@showMap')->name('gmap.show');

    // phone sms
    Route::get('/trysms', 'HomeController@trysms');
    Route::get('/tryemail', 'HomeController@tryemail');
    Route::get('/trylogger', 'HomeController@trylogger');

    Route::get('/subscribe/{email}','HomeController@subscribe');

    });
    // Bulk Image Uploads

Auth::routes();


//contactuser
Route::get('/big-boss/contactuser', 'Admin\ContactUsController@show');
Route::get('/sitemap', 'SitemapController@sitemap');
Route::get('/data/cities', 'DataController@getCitiesByCountryId');


<?php

// ************************************ ADMIN SECTION **********************************************

Route::prefix('admin')->group(function() {

  //------------ ADMIN LOGIN SECTION ------------

  Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
  Route::get('/forgot', 'Admin\LoginController@showForgotForm')->name('admin.forgot');
  Route::post('/forgot', 'Admin\LoginController@forgot')->name('admin.forgot.submit');
  Route::get('/change-password/{token}', 'Admin\LoginController@showChangePassForm')->name('admin.change.token');
  Route::post('/change-password', 'Admin\LoginController@changepass')->name('admin.change.password');
  Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

  //------------ ADMIN LOGIN SECTION ENDS ------------

  //------------ ADMIN NOTIFICATION SECTION ------------

  // Notification Count
  Route::get('/all/notf/count','Admin\NotificationController@all_notf_count')->name('all-notf-count');
  // Notification Count Ends

  // User Notification
  Route::get('/user/notf/show', 'Admin\NotificationController@user_notf_show')->name('user-notf-show');
  Route::get('/user/notf/clear','Admin\NotificationController@user_notf_clear')->name('user-notf-clear');
  // User Notification Ends

  // Order Notification
  Route::get('/order/notf/show', 'Admin\NotificationController@order_notf_show')->name('order-notf-show');
  Route::get('/order/notf/clear','Admin\NotificationController@order_notf_clear')->name('order-notf-clear');
  // Order Notification Ends

  // Product Notification
  Route::get('/product/notf/show', 'Admin\NotificationController@product_notf_show')->name('product-notf-show');
  Route::get('/product/notf/clear','Admin\NotificationController@product_notf_clear')->name('product-notf-clear');
  // Product Notification Ends

  // Product Notification
  Route::get('/conv/notf/show', 'Admin\NotificationController@conv_notf_show')->name('conv-notf-show');
  Route::get('/conv/notf/clear','Admin\NotificationController@conv_notf_clear')->name('conv-notf-clear');
  // Product Notification Ends

  //------------ ADMIN NOTIFICATION SECTION ENDS ------------

  //------------ ADMIN DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
  Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
  Route::post('/profile/update', 'Admin\DashboardController@profileupdate')->name('admin.profile.update');
  Route::get('/password', 'Admin\DashboardController@passwordreset')->name('admin.password');
  Route::post('/password/update', 'Admin\DashboardController@changepass')->name('admin.password.update');
  //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------




  // --------------- ADMIN COUNRTY SECTION ---------------//
  Route::get('/country/datatables', 'Admin\CountryController@datatables')->name('admin-country-datatables');
  Route::get('/manage/country', 'Admin\CountryController@manageCountry')->name('admin-country-index');
  Route::get('/country/status/{id1}/{id2}', 'Admin\CountryController@status')->name('admin-country-status');
  Route::get('/country/delete/{id}', 'Admin\CountryController@delete')->name('admin-country-delete');
  Route::get('/country/tax/datatables', 'Admin\CountryController@taxDatatables')->name('admin-country-tax-datatables');
  Route::get('/manage/country/tax', 'Admin\CountryController@country_tax')->name('admin-country-tax');

  // --------------- ADMIN COUNRTY SECTION END -----------//


  // tax 
  Route::get('/country/set-tax/{id}', 'Admin\CountryController@setTax')->name('admin-set-tax');
  Route::post('/country/set-tax/store/{id}', 'Admin\CountryController@updateTax')->name('admin-tax-update');



  // --------------- ADMIN STATE SECTION --------------------//


  Route::get('/state/datatables/{country}', 'Admin\StateController@datatables')->name('admin-state-datatables');
  Route::get('/manage/state/{country}', 'Admin\StateController@manageState')->name('admin-state-index');
  Route::get('/state/create/{country}', 'Admin\StateController@create')->name('admin-state-create');
  Route::post('/state/store/{country}', 'Admin\StateController@store')->name('admin-state-store');
  Route::get('/state/status/{id1}/{id2}', 'Admin\StateController@status')->name('admin-state-status');
  Route::get('/state/edit/{id}', 'Admin\StateController@edit')->name('admin-state-edit');
  Route::post('/state/update/{id}', 'Admin\StateController@update')->name('admin-state-update');
  Route::get('/state/delete/{id}', 'Admin\StateController@delete')->name('admin-state-delete');


  // --------------- ADMIN STATE SECTION --------------------//




  //------------ ADMIN ORDER SECTION ------------

  Route::group(['middleware'=>'permissions:orders'],function(){

  Route::get('/orders/datatables/{slug}', 'Admin\OrderController@datatables')->name('admin-order-datatables'); //JSON REQUEST
  Route::get('/orders', 'Admin\OrderController@index')->name('admin-order-index');
  Route::get('/local-orders/datatables/{slug}', 'Admin\OrderController@local_order_datatables')->name('admin-local-order-datatables'); //JSON REQUEST
  Route::get('/local-orders', 'Admin\OrderController@local_order')->name('admin-local-order-index');
  Route::get('/order/edit/{id}', 'Admin\OrderController@edit')->name('admin-order-edit');
  Route::post('/order/update/{id}', 'Admin\OrderController@update')->name('admin-order-update');
  Route::get('/orders/pending', 'Admin\OrderController@pending')->name('admin-order-pending');
  Route::get('/orders/processing', 'Admin\OrderController@processing')->name('admin-order-processing');
  Route::get('/orders/delivered', 'Admin\OrderController@delivered')->name('admin-order-delivered');
  Route::get('/orders/completed', 'Admin\OrderController@completed')->name('admin-order-completed');
  Route::get('/orders/declined', 'Admin\OrderController@declined')->name('admin-order-declined');
  Route::get('/order/{id}/show', 'Admin\OrderController@show')->name('admin-order-show');
  Route::get('/order/{id}/invoice', 'Admin\OrderController@invoice')->name('admin-order-invoice');
  Route::get('/order/{id}/print', 'Admin\OrderController@printpage')->name('admin-order-print');
  Route::get('/order/{id}/thermal-print', 'Admin\OrderController@thermalprintpage')->name('admin-order-thermal-print');
  Route::get('/order/{id1}/status/{status}', 'Admin\OrderController@status')->name('admin-order-status');
  Route::post('/order/email/', 'Admin\OrderController@emailsub')->name('admin-order-emailsub');
  Route::post('/order/{id}/license', 'Admin\OrderController@license')->name('admin-order-license');


  Route::get('/total-sold/order/', 'Admin\OrderController@total_sold_order')->name('admin-total-sold-order');
  Route::post('/total-sold/order/count', 'Admin\OrderController@total_sold_order_count')->name('admin-total-sold-order-count');

  // Order Tracking

  Route::get('/order/{id}/track', 'Admin\OrderTrackController@index')->name('admin-order-track');
  Route::get('/order/{id}/trackload', 'Admin\OrderTrackController@load')->name('admin-order-track-load');
  Route::post('/order/track/store', 'Admin\OrderTrackController@store')->name('admin-order-track-store');
  Route::get('/order/track/add', 'Admin\OrderTrackController@add')->name('admin-order-track-add');
  Route::get('/order/track/edit/{id}', 'Admin\OrderTrackController@edit')->name('admin-order-track-edit');
  Route::post('/order/track/update/{id}', 'Admin\OrderTrackController@update')->name('admin-order-track-update');
  Route::get('/order/track/delete/{id}', 'Admin\OrderTrackController@delete')->name('admin-order-track-delete');

  // Order Tracking Ends
  Route::get('/orders/refund/datatables', 'Admin\OrderController@refundDatatables')->name('admin-refund-order-datatables');
  Route::get('/orders/refund/request', 'Admin\OrderController@refundIndex')->name('admin-order-refund');
  Route::get('/orders/refund/request/accept/{id}', 'Admin\OrderController@refundAccept')->name('admin-refund-accept');
  Route::get('/orders/refund/request/reject/{id}', 'Admin\OrderController@refundReject')->name('admin-refund-reject');

  });

  //------------ ADMIN ORDER SECTION ENDS------------
  //------------ ADMIN CUSTOM TEA ORDER SECTION ------------

  Route::group(['middleware'=>'permissions:custom_tea_order'],function(){

    Route::get('/orders/customtea/datatables/{slug}', 'Admin\CustomTeaOrderController@datatables')->name('admin-customtea-order-datatables'); //JSON REQUEST
    Route::get('/orders/customtea', 'Admin\CustomTeaOrderController@index')->name('admin-customtea-order-index');
    Route::get('/customtea-local-orders/datatables/{slug}', 'Admin\CustomTeaOrderController@local_order_datatables')->name('admin-customtea-local-order-datatables'); //JSON REQUEST
    Route::get('/customtea-local-orders', 'Admin\CustomTeaOrderController@local_order')->name('admin-customtea-local-order-index');
    Route::get('/order/customtea/edit/{id}', 'Admin\CustomTeaOrderController@edit')->name('admin-customtea-order-edit');
    Route::post('/order/customtea/update/{id}', 'Admin\CustomTeaOrderController@update')->name('admin-customtea-order-update');
    Route::get('/orders/customtea/pending', 'Admin\CustomTeaOrderController@pending')->name('admin-customtea-order-pending');
    Route::get('/orders/customtea/processing', 'Admin\CustomTeaOrderController@processing')->name('admin-customtea-order-processing');
    Route::get('/orders/customtea/delivered', 'Admin\CustomTeaOrderController@delivered')->name('admin-customtea-order-delivered');
    Route::get('/orders/customtea/completed', 'Admin\CustomTeaOrderController@completed')->name('admin-customtea-order-completed');
    Route::get('/orders/customtea/declined', 'Admin\CustomTeaOrderController@declined')->name('admin-customtea-order-declined');
    Route::get('/order/customtea/{id}/show', 'Admin\CustomTeaOrderController@show')->name('admin-customtea-order-show');
    Route::get('/order/customtea/{id}/invoice', 'Admin\CustomTeaOrderController@invoice')->name('admin-customtea-order-invoice');
    Route::get('/order/customtea/{id}/print', 'Admin\CustomTeaOrderController@printpage')->name('admin-customtea-order-print');
    Route::get('/order/customtea/{id}/thermal-print', 'Admin\CustomTeaOrderController@thermalprintpage')->name('admin-customtea-order-thermal-print');
    Route::get('/order/customtea/{id1}/status/{status}', 'Admin\CustomTeaOrderController@status')->name('admin-customtea-order-status');
    Route::post('/order/customtea/email/', 'Admin\CustomTeaOrderController@emailsub')->name('admin-customtea-order-emailsub');
  
    Route::get('/total-sold/customtea/', 'Admin\CustomTeaOrderController@total_sold_order')->name('admin-customtea-total-sold-order');
    Route::post('/total-sold/customtea/count', 'Admin\CustomTeaOrderController@total_sold_order_count')->name('admin-customtea-total-sold-order-count');
  
    // Order Tracking Ends
    Route::get('/orders/customtea/refund/datatables', 'Admin\CustomTeaOrderController@refundDatatables')->name('admin-customtea-refund-order-datatables');
    Route::get('/orders/customtea/refund/request', 'Admin\CustomTeaOrderController@refundIndex')->name('admin-customtea-order-refund');
    Route::get('/orders/customtea/refund/request/accept/{id}', 'Admin\CustomTeaOrderController@refundAccept')->name('admin-customtea-refund-accept');
    Route::get('/orders/customtea/refund/request/reject/{id}', 'Admin\CustomTeaOrderController@refundReject')->name('admin-customtea-refund-reject');
  
    });
  
    //------------ ADMIN CUSTOM TEA ORDER SECTION ENDS------------


  //------------ ADMIN PRODUCT SECTION ------------

  Route::group(['middleware'=>'permissions:products'],function(){

  Route::get('/products/datatables', 'Admin\ProductController@datatables')->name('admin-prod-datatables'); //JSON REQUEST
  Route::get('/products', 'Admin\ProductController@index')->name('admin-prod-index');

  Route::post('/products/upload/update/{id}', 'Admin\ProductController@uploadUpdate')->name('admin-prod-upload-update');

  Route::get('/products/deactive/datatables', 'Admin\ProductController@deactivedatatables')->name('admin-prod-deactive-datatables'); //JSON REQUEST
  Route::get('/products/deactive', 'Admin\ProductController@deactive')->name('admin-prod-deactive');


  Route::get('/products/catalogs/datatables', 'Admin\ProductController@catalogdatatables')->name('admin-prod-catalog-datatables'); //JSON REQUEST
  Route::get('/products/catalogs/', 'Admin\ProductController@catalogs')->name('admin-prod-catalog-index');

  // CREATE SECTION
  Route::get('/products/types', 'Admin\ProductController@types')->name('admin-prod-types');
  Route::get('/products/physical/create', 'Admin\ProductController@createPhysical')->name('admin-prod-physical-create');
  Route::get('/products/digital/create', 'Admin\ProductController@createDigital')->name('admin-prod-digital-create');
  Route::get('/products/license/create', 'Admin\ProductController@createLicense')->name('admin-prod-license-create');
  Route::post('/products/store', 'Admin\ProductController@store')->name('admin-prod-store');
  Route::get('/getattributes', 'Admin\ProductController@getAttributes')->name('admin-prod-getattributes');
  // CREATE SECTION

    // EDIT SECTION
  Route::get('/products/edit/{id}', 'Admin\ProductController@edit')->name('admin-prod-edit');
  Route::post('/products/edit/{id}', 'Admin\ProductController@update')->name('admin-prod-update');
  // EDIT SECTION ENDS



  // DELETE SECTION
  Route::get('/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-prod-delete');
  // DELETE SECTION ENDS


  Route::get('/products/catalog/{id1}/{id2}', 'Admin\ProductController@catalog')->name('admin-prod-catalog');
  
  // PRODUCT TYPE ENABLE / DESABLE
  Route::get('/products/catalog/{id1}/{id2}', 'Admin\ProductController@catalog')->name('admin-prod-catalog');
  //------------ ADMIN PRODUCT SECTION ENDS------------

  });
  //------------ ADMIN CUSTOM TEA SECTION ------------

  Route::group(['middleware'=>'permissions:customtea'],function(){

    Route::get('/smell-products/datatables', 'Admin\CustomTeaController@smell_datatables')->name('admin-smell-prod-datatables'); //JSON REQUEST
    Route::get('/smell-products', 'Admin\CustomTeaController@smell')->name('admin-smell-prod-index');

    Route::get('/colour-products/datatables', 'Admin\CustomTeaController@colour_datatables')->name('admin-colour-prod-datatables'); //JSON REQUEST
    Route::get('/colour-products', 'Admin\CustomTeaController@colour')->name('admin-colour-prod-index');
  
    
  
    // CREATE SECTION

    Route::get('/products/customtea/create', 'Admin\CustomTeaController@create')->name('admin-prod-customtea-create');
    Route::post('/products/customtea/store', 'Admin\CustomTeaController@store')->name('admin-prod-customtea-store');
    // CREATE SECTION
  
      // EDIT SECTION
    Route::get('/products/customtea/edit/{id}', 'Admin\CustomTeaController@edit')->name('admin-prod-customtea-edit');
    Route::post('/products/customtea/edit/{id}', 'Admin\CustomTeaController@update')->name('admin-prod-customtea-update');
    // EDIT SECTION ENDS
  
    Route::get('/products/customtea/status/{id1}/{id2}', 'Admin\CustomTeaController@status')->name('admin-prod-customtea-status');
  
    // DELETE SECTION
    Route::get('/products/customtea/delete/{id}', 'Admin\CustomTeaController@destroy')->name('admin-prod-customtea-delete');
    // DELETE SECTION ENDS
  
  
   
    //------------ ADMIN CUSTOM TEA SECTION ENDS------------
  
    });
  //------------ ADMIN AFFILIATE PRODUCT SECTION ------------

  Route::group(['middleware'=>'permissions:affilate_products'],function(){

    Route::get('/products/import/create', 'Admin\ImportController@createImport')->name('admin-import-create');
    Route::get('/products/import/edit/{id}', 'Admin\ImportController@edit')->name('admin-import-edit');


    Route::get('/products/import/datatables', 'Admin\ImportController@datatables')->name('admin-import-datatables'); //JSON REQUEST
    Route::get('/products/import/index', 'Admin\ImportController@index')->name('admin-import-index');

    Route::post('/products/import/store', 'Admin\ImportController@store')->name('admin-import-store');
    Route::post('/products/import/update/{id}', 'Admin\ImportController@update')->name('admin-import-update');


    // DELETE SECTION
    Route::get('/affiliate/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-affiliate-prod-delete');
    // DELETE SECTION ENDS

  });

  //------------ ADMIN AFFILIATE PRODUCT SECTION ENDS ------------


  //------------ ADMIN USER SECTION ------------

  Route::group(['middleware'=>'permissions:customers'],function(){

  Route::get('/users/datatables/{slug}', 'Admin\UserController@datatables')->name('admin-user-datatables'); //JSON REQUEST
  Route::get('/users', 'Admin\UserController@index')->name('admin-user-index');
  Route::get('/domestic-users', 'Admin\UserController@domestic_user')->name('admin-domestic-user');
  Route::get('/commercial-users', 'Admin\UserController@commercial_user')->name('admin-commercial-user');
  Route::get('/users/edit/{id}', 'Admin\UserController@edit')->name('admin-user-edit');
  Route::post('/users/edit/{id}', 'Admin\UserController@update')->name('admin-user-update');
  Route::get('/users/delete/{id}', 'Admin\UserController@destroy')->name('admin-user-delete');
  Route::get('/user/{id}/show', 'Admin\UserController@show')->name('admin-user-show');
  Route::get('/users/ban/{id1}/{id2}', 'Admin\UserController@ban')->name('admin-user-ban');
  Route::get('/user/default/image', 'Admin\UserController@image')->name('admin-user-image');
  Route::get('/users/deposit/{id}', 'Admin\UserController@deposit')->name('admin-user-deposit');
  Route::post('/user/deposit/{id}', 'Admin\UserController@depositUpdate')->name('admin-user-deposit-update');
  Route::get('/users/reward/{id}', 'Admin\UserController@reward')->name('admin-user-reward');
  Route::post('/user/reward/{id}', 'Admin\UserController@rewardUpdate')->name('admin-user-reward-update');
  Route::get('/user/default/cashback', 'Admin\UserController@cashback')->name('admin-user-cashback');

  // WITHDRAW SECTION
  Route::get('/users/withdraws/datatables', 'Admin\UserController@withdrawdatatables')->name('admin-withdraw-datatables'); //JSON REQUEST
  Route::get('/users/withdraws', 'Admin\UserController@withdraws')->name('admin-withdraw-index');
  Route::get('/user/withdraw/{id}/show', 'Admin\UserController@withdrawdetails')->name('admin-withdraw-show');
  Route::get('/users/withdraws/accept/{id}', 'Admin\UserController@accept')->name('admin-withdraw-accept');
  Route::get('/user/withdraws/reject/{id}', 'Admin\UserController@reject')->name('admin-withdraw-reject');
  // WITHDRAW SECTION ENDS


  });
  Route::group(['middleware'=>'permissions:deliveryboys'],function(){

    Route::get('/deliveryboys/datatables', 'Admin\DeliveryBoysController@datatables')->name('admin-deliveryboys-datatables'); //JSON REQUEST
    Route::get('/deliveryboys', 'Admin\DeliveryBoysController@index')->name('admin-deliveryboys-index');
    // CREATE SECTION

    Route::get('/deliveryboys/create', 'Admin\DeliveryBoysController@create')->name('admin-deliveryboys-create');
    Route::post('/deliveryboys/store', 'Admin\DeliveryBoysController@store')->name('admin-deliveryboys-store');
    Route::get('/deliveryboys/edit/{id}', 'Admin\DeliveryBoysController@edit')->name('admin-deliveryboys-edit');
    Route::post('/deliveryboys/edit/{id}', 'Admin\DeliveryBoysController@update')->name('admin-deliveryboys-update');
    Route::get('/deliveryboys/delete/{id}', 'Admin\DeliveryBoysController@destroy')->name('admin-deliveryboys-delete');
    Route::get('/deliveryboys/{id}/show', 'Admin\DeliveryBoysController@show')->name('admin-deliveryboys-show');
    Route::get('/deliveryboys/ban/{id1}/{id2}', 'Admin\DeliveryBoysController@ban')->name('admin-deliveryboys-ban');
    Route::get('/deliveryboys/default/commission', 'Admin\DeliveryBoysController@commission')->name('admin-deliveryboys-commission');

  });
  Route::group(['middleware'=>'permissions:salesperson'],function(){

    Route::get('/salesperson/datatables', 'Admin\SalesPersonController@datatables')->name('admin-salesperson-datatables'); //JSON REQUEST
    Route::get('/salesperson', 'Admin\SalesPersonController@index')->name('admin-salesperson-index');
    // CREATE SECTION

    Route::get('/salesperson/create', 'Admin\SalesPersonController@create')->name('admin-salesperson-create');
    Route::post('/salesperson/store', 'Admin\SalesPersonController@store')->name('admin-salesperson-store');
    Route::get('/salesperson/edit/{id}', 'Admin\SalesPersonController@edit')->name('admin-salesperson-edit');
    Route::post('/salesperson/edit/{id}', 'Admin\SalesPersonController@update')->name('admin-salesperson-update');
    Route::get('/salesperson/delete/{id}', 'Admin\SalesPersonController@destroy')->name('admin-salesperson-delete');
    Route::get('/salesperson/{id}/show', 'Admin\SalesPersonController@show')->name('admin-salesperson-show');
    Route::get('/salesperson/ban/{id1}/{id2}', 'Admin\SalesPersonController@ban')->name('admin-salesperson-ban');
    Route::get('/salesperson/default/commission', 'Admin\SalesPersonController@commission')->name('admin-salesperson-commission');


    Route::get('/total-sold/salesperson/', 'Admin\SalesPersonController@total_sold_order')->name('admin-salesperson-total-sold-order');
    Route::post('/total-sold/salesperson/count', 'Admin\SalesPersonController@total_sold_order_count')->name('admin-salesperson-total-sold-order-count');

  });

  //------------ ADMIN USER SECTION ENDS ------------

  //------------ ADMIN VENDOR SECTION ------------

  Route::group(['middleware'=>'permissions:vendors'],function(){

  Route::get('/vendors/datatables', 'Admin\VendorController@datatables')->name('admin-vendor-datatables');
  Route::get('/vendors', 'Admin\VendorController@index')->name('admin-vendor-index');

  Route::get('/vendors/{id}/show', 'Admin\VendorController@show')->name('admin-vendor-show');
  Route::get('/vendors/secret/login/{id}', 'Admin\VendorController@secret')->name('admin-vendor-secret');
  Route::get('/vendor/edit/{id}', 'Admin\VendorController@edit')->name('admin-vendor-edit');
  Route::post('/vendor/edit/{id}', 'Admin\VendorController@update')->name('admin-vendor-update');

  Route::get('/vendor/verify/{id}', 'Admin\VendorController@verify')->name('admin-vendor-verify');
  Route::post('/vendor/verify/{id}', 'Admin\VendorController@verifySubmit')->name('admin-vendor-verify-submit');

  Route::get('/vendors', 'Admin\VendorController@index')->name('admin-vendor-index');
  Route::get('/vendor/color', 'Admin\VendorController@color')->name('admin-vendor-color');
  Route::get('/vendors/status/{id1}/{id2}', 'Admin\VendorController@status')->name('admin-vendor-st');
  Route::get('/vendors/delete/{id}', 'Admin\VendorController@destroy')->name('admin-vendor-delete');

  Route::get('/vendors/withdraws/datatables', 'Admin\VendorController@withdrawdatatables')->name('admin-vendor-withdraw-datatables'); //JSON REQUEST
  Route::get('/vendors/withdraws', 'Admin\VendorController@withdraws')->name('admin-vendor-withdraw-index');
  Route::get('/vendors/withdraw/{id}/show', 'Admin\VendorController@withdrawdetails')->name('admin-vendor-withdraw-show');
  Route::get('/vendors/withdraws/accept/{id}', 'Admin\VendorController@accept')->name('admin-vendor-withdraw-accept');
  Route::get('/vendors/withdraws/reject/{id}', 'Admin\VendorController@reject')->name('admin-vendor-withdraw-reject');

  //  Vendor Registration Section

  Route::get('/general-settings/vendor-registration/{status}', 'Admin\GeneralSettingController@regvendor')->name('admin-gs-regvendor');

  //  Vendor Registration Section Ends



  // Verification Section

    Route::get('/verificatons/datatables/{status}', 'Admin\VerificationController@datatables')->name('admin-vr-datatables');
    Route::get('/verificatons', 'Admin\VerificationController@index')->name('admin-vr-index');
    Route::get('/verificatons/pendings', 'Admin\VerificationController@pending')->name('admin-vr-pending');

    Route::get('/verificatons/show', 'Admin\VerificationController@show')->name('admin-vr-show');
    Route::get('/verificatons/edit/{id}', 'Admin\VerificationController@edit')->name('admin-vr-edit');
    Route::post('/verificatons/edit/{id}', 'Admin\VerificationController@update')->name('admin-vr-update');
    Route::get('/verificatons/status/{id1}/{id2}', 'Admin\VerificationController@status')->name('admin-vr-st');
    Route::get('/verificatons/delete/{id}', 'Admin\VerificationController@destroy')->name('admin-vr-delete');



  // Verification Section Ends



  });




  //------------ ADMIN VENDOR SECTION ENDS ------------


  //------------ ADMIN SUBSCRIPTION SECTION ------------

  Route::group(['middleware'=>'permissions:vendor_subscription_plans'],function(){

  Route::get('/subscription/datatables', 'Admin\SubscriptionController@datatables')->name('admin-subscription-datatables');
  Route::get('/subscription', 'Admin\SubscriptionController@index')->name('admin-subscription-index');
  Route::get('/subscription/create', 'Admin\SubscriptionController@create')->name('admin-subscription-create');
  Route::post('/subscription/create', 'Admin\SubscriptionController@store')->name('admin-subscription-store');
  Route::get('/subscription/edit/{id}', 'Admin\SubscriptionController@edit')->name('admin-subscription-edit');
  Route::post('/subscription/edit/{id}', 'Admin\SubscriptionController@update')->name('admin-subscription-update');
  Route::get('/subscription/delete/{id}', 'Admin\SubscriptionController@destroy')->name('admin-subscription-delete');

  Route::get('/vendors/subs/datatables', 'Admin\VendorController@subsdatatables')->name('admin-vendor-subs-datatables');
  Route::get('/vendors/subs', 'Admin\VendorController@subs')->name('admin-vendor-subs');
  Route::get('/vendors/sub/{id}', 'Admin\VendorController@sub')->name('admin-vendor-sub');

  });

  //------------ ADMIN SUBSCRIPTION SECTION ENDS ------------



  // ------------------ CUSTOM ORDER CREATE ADMIN SECTION -------------------//
    Route::get('order/create','Admin\CustomOrderController@index')->name('admin-custom-order');
    Route::get('order/create/customer/form','Admin\CustomOrderController@loadForm')->name('admin.custom.order.form');
    Route::get('/item/quick/view/{id}/','Admin\CustomOrderController@quick')->name('admin.product.quick');
    Route::post('/custom/order/create/','Admin\CustomOrderController@store')->name('admin-custom-order-store');
  // ------------------ CUSTOM ORDER CREATE ADMIN SECTION -------------------//


  //------------ ADMIN CATEGORY SECTION ------------

  Route::group(['middleware'=>'permissions:categories'],function(){

  Route::get('/category/datatables', 'Admin\CategoryController@datatables')->name('admin-cat-datatables'); //JSON REQUEST
  Route::get('/category', 'Admin\CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'Admin\CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'Admin\CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'Admin\CategoryController@edit')->name('admin-cat-edit');
  Route::post('/category/edit/{id}', 'Admin\CategoryController@update')->name('admin-cat-update');
  Route::get('/category/delete/{id}', 'Admin\CategoryController@destroy')->name('admin-cat-delete');
  Route::get('/category/status/{id1}/{id2}', 'Admin\CategoryController@status')->name('admin-cat-status');


  //------------ ADMIN ATTRIBUTE SECTION ------------

  Route::get('/attribute/datatables', 'Admin\AttributeController@datatables')->name('admin-attr-datatables'); //JSON REQUEST
  Route::get('/attribute', 'Admin\AttributeController@index')->name('admin-attr-index');
  Route::get('/attribute/{catid}/attrCreateForCategory', 'Admin\AttributeController@attrCreateForCategory')->name('admin-attr-createForCategory');
  Route::get('/attribute/{subcatid}/attrCreateForSubcategory', 'Admin\AttributeController@attrCreateForSubcategory')->name('admin-attr-createForSubcategory');
  Route::get('/attribute/{childcatid}/attrCreateForChildcategory', 'Admin\AttributeController@attrCreateForChildcategory')->name('admin-attr-createForChildcategory');
  Route::post('/attribute/store', 'Admin\AttributeController@store')->name('admin-attr-store');
  Route::get('/attribute/{id}/manage', 'Admin\AttributeController@manage')->name('admin-attr-manage');
  Route::get('/attribute/{attrid}/edit', 'Admin\AttributeController@edit')->name('admin-attr-edit');
  Route::post('/attribute/edit/{id}', 'Admin\AttributeController@update')->name('admin-attr-update');
  Route::get('/attribute/{id}/options', 'Admin\AttributeController@options')->name('admin-attr-options');
  Route::get('/attribute/delete/{id}', 'Admin\AttributeController@destroy')->name('admin-attr-delete');


  // SUBCATEGORY SECTION ------------

  Route::get('/subcategory/datatables', 'Admin\SubCategoryController@datatables')->name('admin-subcat-datatables'); //JSON REQUEST
  Route::get('/subcategory', 'Admin\SubCategoryController@index')->name('admin-subcat-index');
  Route::get('/subcategory/create', 'Admin\SubCategoryController@create')->name('admin-subcat-create');
  Route::post('/subcategory/create', 'Admin\SubCategoryController@store')->name('admin-subcat-store');
  Route::get('/subcategory/edit/{id}', 'Admin\SubCategoryController@edit')->name('admin-subcat-edit');
  Route::post('/subcategory/edit/{id}', 'Admin\SubCategoryController@update')->name('admin-subcat-update');
  Route::get('/subcategory/delete/{id}', 'Admin\SubCategoryController@destroy')->name('admin-subcat-delete');
  Route::get('/subcategory/status/{id1}/{id2}', 'Admin\SubCategoryController@status')->name('admin-subcat-status');
  Route::get('/load/subcategories/{id}/', 'Admin\SubCategoryController@load')->name('admin-subcat-load'); //JSON REQUEST

  // SUBCATEGORY SECTION ENDS------------

  // CHILDCATEGORY SECTION ------------

  Route::get('/childcategory/datatables', 'Admin\ChildCategoryController@datatables')->name('admin-childcat-datatables'); //JSON REQUEST
  Route::get('/childcategory', 'Admin\ChildCategoryController@index')->name('admin-childcat-index');
  Route::get('/childcategory/create', 'Admin\ChildCategoryController@create')->name('admin-childcat-create');
  Route::post('/childcategory/create', 'Admin\ChildCategoryController@store')->name('admin-childcat-store');
  Route::get('/childcategory/edit/{id}', 'Admin\ChildCategoryController@edit')->name('admin-childcat-edit');
  Route::post('/childcategory/edit/{id}', 'Admin\ChildCategoryController@update')->name('admin-childcat-update');
  Route::get('/childcategory/delete/{id}', 'Admin\ChildCategoryController@destroy')->name('admin-childcat-delete');
  Route::get('/childcategory/status/{id1}/{id2}', 'Admin\ChildCategoryController@status')->name('admin-childcat-status');
  Route::get('/load/childcategories/{id}/', 'Admin\ChildCategoryController@load')->name('admin-childcat-load'); //JSON REQUEST

  // CHILDCATEGORY SECTION ENDS------------


  //------------ ADMIN CROSS SELLING RELATION SECTION STARTS ------------

  Route::get('/csrelation/datatables', 'Admin\CsRelationController@datatables')->name('admin-csrelation-datatables'); //JSON REQUEST
  Route::get('/csrelation', 'Admin\CsRelationController@index')->name('admin-csrelation-index');
  Route::get('/csrelation/create', 'Admin\CsRelationController@create')->name('admin-csrelation-create');
  Route::post('/csrelation/create', 'Admin\CsRelationController@store')->name('admin-csrelation-store');
  Route::get('/csrelation/edit/{id}', 'Admin\CsRelationController@edit')->name('admin-csrelation-edit');
  Route::post('/csrelation/edit/{id}', 'Admin\CsRelationController@update')->name('admin-csrelation-update');
  Route::get('/csrelation/delete/{id}', 'Admin\CsRelationController@destroy')->name('admin-csrelation-delete');
  Route::get('/csrelation/types/{type}', 'Admin\CsRelationController@types')->name('admin-csrelation-types');

  //------------ ADMIN CROSS SELLING RELATION SECTION ENDS ------------

  });


  Route::group(['middleware'=>'permissions:commison'],function(){

  // --------------------- Commission section route------------------------//
  Route::get('/main/commissions','Admin\CommissionController@main_commission')->name('admin-main-commission-index');
  Route::get('/category/commission/datatables','Admin\CommissionController@category_commission_datatables')->name('admin-category-commission-datatables');
  Route::get('/category/commissions','Admin\CommissionController@category_commission')->name('admin-category-commission-index');
  Route::get('/category/commission/create/{id}','Admin\CommissionController@category_commission_create')->name('admin-category-commission-create');
  Route::post('/category/commission/store/{id}','Admin\CommissionController@category_commission_store')->name('admin-category-commission-store');
    });



  //------------ ADMIN CATEGORY SECTION ENDS------------

  Route::group(['middleware'=>'permissions:earning'],function(){

  // -------------------------- Admin Total Income Route --------------------------//
    Route::get('tax/calculate','Admin\IncomeController@taxCalculate')->name('admin-tax-calculate-income');
    Route::get('subscription/earning','Admin\IncomeController@subscriptionIncome')->name('admin-subscription-income');
    Route::get('withdraw/earning','Admin\IncomeController@withdrawIncome')->name('admin-withdraw-income');
    Route::get('commission/earning','Admin\IncomeController@commissionIncome')->name('admin-commission-income');
  // -------------------------- Admin Total Income Route --------------------------//
  });

  //------------ ADMIN CSV IMPORT SECTION ------------

  Route::group(['middleware'=>'permissions:bulk_product_upload'],function(){

    Route::get('/products/import', 'Admin\ProductController@import')->name('admin-prod-import');
    Route::post('/products/import-submit', 'Admin\ProductController@importSubmit')->name('admin-prod-importsubmit');

    });

  //------------ ADMIN CSV IMPORT SECTION ENDS ------------

  //------------ ADMIN PRODUCT DISCUSSION SECTION ------------

    Route::group(['middleware'=>'permissions:product_discussion'],function(){

    // RATING SECTION ENDS------------

    Route::get('/ratings/datatables', 'Admin\RatingController@datatables')->name('admin-rating-datatables'); //JSON REQUEST
    Route::get('/ratings', 'Admin\RatingController@index')->name('admin-rating-index');
    Route::get('/ratings/delete/{id}', 'Admin\RatingController@destroy')->name('admin-rating-delete');
    Route::get('/ratings/show/{id}', 'Admin\RatingController@show')->name('admin-rating-show');

    // RATING SECTION ENDS------------

    // COMMENT SECTION ------------

    Route::get('/comments/datatables', 'Admin\CommentController@datatables')->name('admin-comment-datatables'); //JSON REQUEST
    Route::get('/comments', 'Admin\CommentController@index')->name('admin-comment-index');
    Route::get('/comments/delete/{id}', 'Admin\CommentController@destroy')->name('admin-comment-delete');
    Route::get('/comments/show/{id}', 'Admin\CommentController@show')->name('admin-comment-show');

    // COMMENT CHECK
    Route::get('/general-settings/comment/{status}', 'Admin\GeneralSettingController@comment')->name('admin-gs-iscomment');
    // COMMENT CHECK ENDS


    // COMMENT SECTION ENDS ------------

    // REPORT SECTION ------------

    Route::get('/reports/datatables', 'Admin\ReportController@datatables')->name('admin-report-datatables'); //JSON REQUEST
    Route::get('/reports', 'Admin\ReportController@index')->name('admin-report-index');
    Route::get('/reports/delete/{id}', 'Admin\ReportController@destroy')->name('admin-report-delete');
    Route::get('/reports/show/{id}', 'Admin\ReportController@show')->name('admin-report-show');

    // REPORT CHECK
    Route::get('/general-settings/report/{status}', 'Admin\GeneralSettingController@isreport')->name('admin-gs-isreport');
    // REPORT CHECK ENDS

    // REPORT SECTION ENDS ------------

    });

 //------------ ADMIN PRODUCT DISCUSSION SECTION ENDS ------------


  //------------ ADMIN COUPON SECTION ------------

  Route::group(['middleware'=>'permissions:set_coupons'],function(){

  Route::get('/coupon/datatables', 'Admin\CouponController@datatables')->name('admin-coupon-datatables'); //JSON REQUEST
  Route::get('/coupon', 'Admin\CouponController@index')->name('admin-coupon-index');
  Route::get('/coupon/create', 'Admin\CouponController@create')->name('admin-coupon-create');
  Route::post('/coupon/create', 'Admin\CouponController@store')->name('admin-coupon-store');
  Route::get('/coupon/edit/{id}', 'Admin\CouponController@edit')->name('admin-coupon-edit');
  Route::post('/coupon/edit/{id}', 'Admin\CouponController@update')->name('admin-coupon-update');
  Route::get('/coupon/delete/{id}', 'Admin\CouponController@destroy')->name('admin-coupon-delete');
  Route::get('/coupon/status/{id1}/{id2}', 'Admin\CouponController@status')->name('admin-coupon-status');

  });

  //------------ ADMIN COUPON SECTION ENDS------------

  //------------ ADMIN BLOG SECTION ------------

  Route::group(['middleware'=>'permissions:blog'],function(){

  Route::get('/blog/datatables', 'Admin\BlogController@datatables')->name('admin-blog-datatables'); //JSON REQUEST
  Route::get('/blog', 'Admin\BlogController@index')->name('admin-blog-index');
  Route::get('/blog/create', 'Admin\BlogController@create')->name('admin-blog-create');
  Route::post('/blog/create', 'Admin\BlogController@store')->name('admin-blog-store');
  Route::get('/blog/edit/{id}', 'Admin\BlogController@edit')->name('admin-blog-edit');
  Route::post('/blog/edit/{id}', 'Admin\BlogController@update')->name('admin-blog-update');
  Route::get('/blog/delete/{id}', 'Admin\BlogController@destroy')->name('admin-blog-delete');

  Route::get('/blog/category/datatables', 'Admin\BlogCategoryController@datatables')->name('admin-cblog-datatables'); //JSON REQUEST
  Route::get('/blog/category', 'Admin\BlogCategoryController@index')->name('admin-cblog-index');
  Route::get('/blog/category/create', 'Admin\BlogCategoryController@create')->name('admin-cblog-create');
  Route::post('/blog/category/create', 'Admin\BlogCategoryController@store')->name('admin-cblog-store');
  Route::get('/blog/category/edit/{id}', 'Admin\BlogCategoryController@edit')->name('admin-cblog-edit');
  Route::post('/blog/category/edit/{id}', 'Admin\BlogCategoryController@update')->name('admin-cblog-update');
  Route::get('/blog/category/delete/{id}', 'Admin\BlogCategoryController@destroy')->name('admin-cblog-delete');

  });

  //------------ ADMIN BLOG SECTION ENDS ------------


  //------------ ADMIN USER MESSAGE SECTION ------------

  Route::group(['middleware'=>'permissions:messages'],function(){

  Route::get('/messages/datatables/{type}', 'Admin\MessageController@datatables')->name('admin-message-datatables');
  Route::get('/tickets', 'Admin\MessageController@index')->name('admin-message-index');
  Route::get('/disputes', 'Admin\MessageController@disputes')->name('admin-message-dispute');
  Route::get('/message/{id}', 'Admin\MessageController@message')->name('admin-message-show');
  Route::get('/message/load/{id}', 'Admin\MessageController@messageshow')->name('admin-message-load');
  Route::post('/message/post', 'Admin\MessageController@postmessage')->name('admin-message-store');
  Route::get('/message/{id}/delete', 'Admin\MessageController@messagedelete')->name('admin-message-delete');
  Route::post('/user/send/message', 'Admin\MessageController@usercontact')->name('admin-send-message');

  });

  //------------ ADMIN USER MESSAGE SECTION ENDS ------------

  //------------ ADMIN GENERAL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:general_settings'],function(){

  Route::get('/general-settings/logo', 'Admin\GeneralSettingController@logo')->name('admin-gs-logo');
  Route::get('/general-settings/favicon', 'Admin\GeneralSettingController@fav')->name('admin-gs-fav');
  Route::get('/general-settings/loader', 'Admin\GeneralSettingController@load')->name('admin-gs-load');
  Route::get('/general-settings/contents', 'Admin\GeneralSettingController@contents')->name('admin-gs-contents');
  Route::get('/general-settings/footer', 'Admin\GeneralSettingController@footer')->name('admin-gs-footer');
  Route::get('/general-settings/affilate', 'Admin\GeneralSettingController@affilate')->name('admin-gs-affilate');
  Route::get('/general-settings/error-banner', 'Admin\GeneralSettingController@errorbanner')->name('admin-gs-error-banner');
  Route::get('/general-settings/popup', 'Admin\GeneralSettingController@popup')->name('admin-gs-popup');
  Route::get('/general-settings/selling_category', 'Admin\GeneralSettingController@selling_category')->name('admin-gs-selling-category');
  Route::get('/general-settings/login_background', 'Admin\GeneralSettingController@login_background')->name('admin-gs-login-background');
  Route::get('/general-settings/newsletter_banner', 'Admin\GeneralSettingController@newsletter_banner')->name('admin-gs-newsletter-banner');
  Route::get('/general-settings/maintenance', 'Admin\GeneralSettingController@maintain')->name('admin-gs-maintenance');
  Route::get('/product/type/manage', 'Admin\GeneralSettingController@product_type_manage')->name('admin-gs-product-type');
  Route::get('/product/type/manage/status/{field}/{status}', 'Admin\GeneralSettingController@product_type_change_status')->name('admin-gs-product-type-status');
  //------------ ADMIN PICKUP LOACTION ------------

  Route::get('/pickup/datatables', 'Admin\PickupController@datatables')->name('admin-pick-datatables'); //JSON REQUEST
  Route::get('/pickup', 'Admin\PickupController@index')->name('admin-pick-index');
  Route::get('/pickup/create', 'Admin\PickupController@create')->name('admin-pick-create');
  Route::post('/pickup/create', 'Admin\PickupController@store')->name('admin-pick-store');
  Route::get('/pickup/edit/{id}', 'Admin\PickupController@edit')->name('admin-pick-edit');
  Route::post('/pickup/edit/{id}', 'Admin\PickupController@update')->name('admin-pick-update');
  Route::get('/pickup/delete/{id}', 'Admin\PickupController@destroy')->name('admin-pick-delete');

  //------------ ADMIN PICKUP LOACTION ENDS ------------
  //------------ ADMIN STOCK MANAGEMENT ------------

  Route::get('/stock-management/datatables', 'Admin\StockManagementController@datatables')->name('admin-stock-management-datatables'); //JSON REQUEST
  Route::get('/stock-management', 'Admin\StockManagementController@index')->name('admin-stock-management-index');
  Route::get('/stock-management/create', 'Admin\StockManagementController@create')->name('admin-stock-management-create');
  Route::post('/stock-management/create', 'Admin\StockManagementController@store')->name('admin-stock-management-store');
  Route::get('/stock-management/edit/{id}', 'Admin\StockManagementController@edit')->name('admin-stock-management-edit');
  Route::post('/stock-management/edit/{id}', 'Admin\StockManagementController@update')->name('admin-stock-management-update');
  Route::get('/stock-management/delete/{id}', 'Admin\StockManagementController@destroy')->name('admin-stock-management-delete');

  //------------ ADMIN STOCK MANAGEMENT ENDS ------------

  //------------ ADMIN SHIPPING ------------

  Route::get('/shipping/datatables', 'Admin\ShippingController@datatables')->name('admin-shipping-datatables');
  Route::get('/shipping', 'Admin\ShippingController@index')->name('admin-shipping-index');
  Route::get('/shipping/create', 'Admin\ShippingController@create')->name('admin-shipping-create');
  Route::post('/shipping/create', 'Admin\ShippingController@store')->name('admin-shipping-store');
  Route::get('/shipping/edit/{id}', 'Admin\ShippingController@edit')->name('admin-shipping-edit');
  Route::post('/shipping/edit/{id}', 'Admin\ShippingController@update')->name('admin-shipping-update');
  Route::get('/shipping/delete/{id}', 'Admin\ShippingController@destroy')->name('admin-shipping-delete');

  //------------ ADMIN SHIPPING ENDS ------------

  //------------ ADMIN PACKAGE ------------

  Route::get('/package/datatables', 'Admin\PackageController@datatables')->name('admin-package-datatables');
  Route::get('/package', 'Admin\PackageController@index')->name('admin-package-index');
  Route::get('/package/create', 'Admin\PackageController@create')->name('admin-package-create');
  Route::post('/package/create', 'Admin\PackageController@store')->name('admin-package-store');
  Route::get('/package/edit/{id}', 'Admin\PackageController@edit')->name('admin-package-edit');
  Route::post('/package/edit/{id}', 'Admin\PackageController@update')->name('admin-package-update');
  Route::get('/package/delete/{id}', 'Admin\PackageController@destroy')->name('admin-package-delete');

  //------------ ADMIN PACKAGE ENDS------------



  //------------ ADMIN GENERAL SETTINGS JSON SECTION ------------

  // General Setting Section
  Route::get('/general-settings/home/{status}', 'Admin\GeneralSettingController@ishome')->name('admin-gs-ishome');
  Route::get('/general-settings/disqus/{status}', 'Admin\GeneralSettingController@isdisqus')->name('admin-gs-isdisqus');
  Route::get('/general-settings/loader/{status}', 'Admin\GeneralSettingController@isloader')->name('admin-gs-isloader');
  Route::get('/general-settings/email-verify/{status}', 'Admin\GeneralSettingController@isemailverify')->name('admin-gs-is-email-verify');
  Route::get('/general-settings/popup/{status}', 'Admin\GeneralSettingController@ispopup')->name('admin-gs-ispopup');

  Route::get('/general-settings/admin/loader/{status}', 'Admin\GeneralSettingController@isadminloader')->name('admin-gs-is-admin-loader');
  Route::get('/general-settings/talkto/{status}', 'Admin\GeneralSettingController@talkto')->name('admin-gs-talkto');

  Route::get('/general-settings/multiple/shipping/{status}', 'Admin\GeneralSettingController@mship')->name('admin-gs-mship');
  Route::get('/general-settings/multiple/packaging/{status}', 'Admin\GeneralSettingController@mpackage')->name('admin-gs-mpackage');
  Route::get('/general-settings/security/{status}', 'Admin\GeneralSettingController@issecure')->name('admin-gs-secure');
  Route::get('/general-settings/stock/{status}', 'Admin\GeneralSettingController@stock')->name('admin-gs-stock');
  Route::get('/general-settings/maintain/{status}', 'Admin\GeneralSettingController@ismaintain')->name('admin-gs-maintain');
  //  Affilte Section

  Route::get('/general-settings/affilate/{status}', 'Admin\GeneralSettingController@isaffilate')->name('admin-gs-isaffilate');

  //  Capcha Section

  Route::get('/general-settings/capcha/{status}', 'Admin\GeneralSettingController@iscapcha')->name('admin-gs-iscapcha');


  //------------ ADMIN GENERAL SETTINGS JSON SECTION ENDS------------




  });

  //------------ ADMIN GENERAL SETTINGS SECTION ENDS ------------


  //------------ ADMIN HOME PAGE SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:home_page_settings'],function(){

  //------------ ADMIN SLIDER SECTION ------------

  Route::get('/slider/datatables', 'Admin\SliderController@datatables')->name('admin-sl-datatables'); //JSON REQUEST
  Route::get('/slider', 'Admin\SliderController@index')->name('admin-sl-index');
  Route::get('/slider/create', 'Admin\SliderController@create')->name('admin-sl-create');
  Route::post('/slider/create', 'Admin\SliderController@store')->name('admin-sl-store');
  Route::get('/slider/edit/{id}', 'Admin\SliderController@edit')->name('admin-sl-edit');
  Route::post('/slider/edit/{id}', 'Admin\SliderController@update')->name('admin-sl-update');
  Route::get('/slider/delete/{id}', 'Admin\SliderController@destroy')->name('admin-sl-delete');

  //------------ ADMIN SLIDER SECTION ENDS ------------

  //------------ ADMIN SERVICE SECTION ------------

  Route::get('/service/datatables', 'Admin\ServiceController@datatables')->name('admin-service-datatables'); //JSON REQUEST
  Route::get('/service', 'Admin\ServiceController@index')->name('admin-service-index');
  Route::get('/service/create', 'Admin\ServiceController@create')->name('admin-service-create');
  Route::post('/service/create', 'Admin\ServiceController@store')->name('admin-service-store');
  Route::get('/service/edit/{id}', 'Admin\ServiceController@edit')->name('admin-service-edit');
  Route::post('/service/edit/{id}', 'Admin\ServiceController@update')->name('admin-service-update');
  Route::get('/service/delete/{id}', 'Admin\ServiceController@destroy')->name('admin-service-delete');

  //------------ ADMIN SERVICE SECTION ENDS ------------

  //------------ ADMIN BANNER SECTION ------------

  Route::get('/banner/datatables/{type}', 'Admin\BannerController@datatables')->name('admin-sb-datatables'); //JSON REQUEST
  Route::get('top/small/banner/', 'Admin\BannerController@index')->name('admin-sb-index');
  Route::get('large/banner/', 'Admin\BannerController@large')->name('admin-sb-large');
  Route::get('bottom/small/banner/', 'Admin\BannerController@bottom')->name('admin-sb-bottom');
  Route::get('top/small/banner/create', 'Admin\BannerController@create')->name('admin-sb-create');
  Route::get('large/banner/create', 'Admin\BannerController@largecreate')->name('admin-sb-create-large');
  Route::get('bottom/small/banner/create', 'Admin\BannerController@bottomcreate')->name('admin-sb-create-bottom');


  Route::post('/banner/create', 'Admin\BannerController@store')->name('admin-sb-store');
  Route::get('/banner/edit/{id}', 'Admin\BannerController@edit')->name('admin-sb-edit');
  Route::post('/banner/edit/{id}', 'Admin\BannerController@update')->name('admin-sb-update');
  Route::get('/banner/delete/{id}', 'Admin\BannerController@destroy')->name('admin-sb-delete');

  //------------ ADMIN BANNER SECTION ENDS ------------

  //------------ ADMIN REVIEW SECTION ------------

  Route::get('/review/datatables', 'Admin\ReviewController@datatables')->name('admin-review-datatables'); //JSON REQUEST
  Route::get('/review', 'Admin\ReviewController@index')->name('admin-review-index');
  Route::get('/review/create', 'Admin\ReviewController@create')->name('admin-review-create');
  Route::post('/review/create', 'Admin\ReviewController@store')->name('admin-review-store');
  Route::get('/review/edit/{id}', 'Admin\ReviewController@edit')->name('admin-review-edit');
  Route::post('/review/edit/{id}', 'Admin\ReviewController@update')->name('admin-review-update');
  Route::get('/review/delete/{id}', 'Admin\ReviewController@destroy')->name('admin-review-delete');

  //------------ ADMIN REVIEW SECTION ENDS ------------


  //------------ ADMIN PARTNER SECTION ------------

  Route::get('/partner/datatables', 'Admin\PartnerController@datatables')->name('admin-partner-datatables');
  Route::get('/partner', 'Admin\PartnerController@index')->name('admin-partner-index');
  Route::get('/partner/create', 'Admin\PartnerController@create')->name('admin-partner-create');
  Route::post('/partner/create', 'Admin\PartnerController@store')->name('admin-partner-store');
  Route::get('/partner/edit/{id}', 'Admin\PartnerController@edit')->name('admin-partner-edit');
  Route::post('/partner/edit/{id}', 'Admin\PartnerController@update')->name('admin-partner-update');
  Route::get('/partner/delete/{id}', 'Admin\PartnerController@destroy')->name('admin-partner-delete');

  //------------ ADMIN PARTNER SECTION ENDS ------------


  //------------ ADMIN PAGE SETTINGS SECTION ------------

  Route::get('/page-settings/customize', 'Admin\PageSettingController@customize')->name('admin-ps-customize');
  Route::get('/page-settings/big-save', 'Admin\PageSettingController@big_save')->name('admin-ps-big-save');
  Route::get('/page-settings/best-seller', 'Admin\PageSettingController@best_seller')->name('admin-ps-best-seller');
  Route::get('/page-settings/slider-right', 'Admin\PageSettingController@slider_right')->name('admin-ps-slider-right');
  Route::get('/page-settings/gallary-banner/large', 'Admin\PageSettingController@gallary_large')->name('admin-ps-gallary-large');
  Route::get('/page-settings/gallary-banner/small', 'Admin\PageSettingController@gallary_small')->name('admin-ps-gallary-small');


  });

  //------------ ADMIN HOME PAGE SETTINGS SECTION ENDS ------------

  Route::group(['middleware'=>'permissions:menu_page_settings'],function(){

  //------------ ADMIN MENU PAGE SETTINGS SECTION ------------

  //------------ ADMIN FAQ SECTION ------------

  Route::get('/faq/datatables', 'Admin\FaqController@datatables')->name('admin-faq-datatables'); //JSON REQUEST
  Route::get('/faq', 'Admin\FaqController@index')->name('admin-faq-index');
  Route::get('/faq/create', 'Admin\FaqController@create')->name('admin-faq-create');
  Route::post('/faq/create', 'Admin\FaqController@store')->name('admin-faq-store');
  Route::get('/faq/edit/{id}', 'Admin\FaqController@edit')->name('admin-faq-edit');
  Route::post('/faq/update/{id}', 'Admin\FaqController@update')->name('admin-faq-update');
  Route::get('/faq/delete/{id}', 'Admin\FaqController@destroy')->name('admin-faq-delete');

  //------------ ADMIN FAQ SECTION ENDS ------------


  //------------ ADMIN PAGE SECTION ------------

  Route::get('/page/datatables', 'Admin\PageController@datatables')->name('admin-page-datatables'); //JSON REQUEST
  Route::get('/page', 'Admin\PageController@index')->name('admin-page-index');
  Route::get('/page/create', 'Admin\PageController@create')->name('admin-page-create');
  Route::post('/page/create', 'Admin\PageController@store')->name('admin-page-store');
  Route::get('/page/edit/{id}', 'Admin\PageController@edit')->name('admin-page-edit');
  Route::post('/page/update/{id}', 'Admin\PageController@update')->name('admin-page-update');
  Route::get('/page/delete/{id}', 'Admin\PageController@destroy')->name('admin-page-delete');
  Route::get('/page/header/{id1}/{id2}', 'Admin\PageController@header')->name('admin-page-header');
  Route::get('/page/footer/{id1}/{id2}', 'Admin\PageController@footer')->name('admin-page-footer');

  //------------ ADMIN PAGE SECTION ENDS------------


  Route::get('/general-settings/contact/{status}', 'Admin\GeneralSettingController@iscontact')->name('admin-gs-iscontact');
  Route::get('/general-settings/faq/{status}', 'Admin\GeneralSettingController@isfaq')->name('admin-gs-isfaq');
  Route::get('/general-settings/reward/{status}', 'Admin\GeneralSettingController@isreward')->name('admin-gs-is_reward');
  Route::get('/page-settings/contact', 'Admin\PageSettingController@contact')->name('admin-ps-contact');
  Route::post('/page-settings/update/all', 'Admin\PageSettingController@update')->name('admin-ps-update');

  });

  //------------ ADMIN MENU PAGE SETTINGS SECTION ENDS ------------



  //------------ ADMIN EMAIL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:emails_settings'],function(){

  Route::get('/email-templates/datatables', 'Admin\EmailController@datatables')->name('admin-mail-datatables');
  Route::get('/email-templates', 'Admin\EmailController@index')->name('admin-mail-index');
  Route::get('/email-templates/{id}', 'Admin\EmailController@edit')->name('admin-mail-edit');
  Route::post('/email-templates/{id}', 'Admin\EmailController@update')->name('admin-mail-update');
  Route::get('/email-config', 'Admin\EmailController@config')->name('admin-mail-config');
  Route::get('/groupemail', 'Admin\EmailController@groupemail')->name('admin-group-show');
  Route::post('/groupemailpost', 'Admin\EmailController@groupemailpost')->name('admin-group-submit');
  Route::get('/issmtp/{status}', 'Admin\GeneralSettingController@issmtp')->name('admin-gs-issmtp');

  });

  //------------ ADMIN EMAIL SETTINGS SECTION ENDS ------------



  //------------ ADMIN PAYMENT SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:payment_settings'],function(){

  // Payment Informations

  Route::get('/payment-informations', 'Admin\GeneralSettingController@paymentsinfo')->name('admin-gs-payments');

  Route::get('/general-settings/guest/{status}', 'Admin\GeneralSettingController@guest')->name('admin-gs-guest');
  Route::get('/general-settings/paypal/{status}', 'Admin\GeneralSettingController@paypal')->name('admin-gs-paypal');
  Route::get('/general-settings/instamojo/{status}', 'Admin\GeneralSettingController@instamojo')->name('admin-gs-instamojo');
  Route::get('/general-settings/paystack/{status}', 'Admin\GeneralSettingController@paystack')->name('admin-gs-paystack');
  Route::get('/general-settings/stripe/{status}', 'Admin\GeneralSettingController@stripe')->name('admin-gs-stripe');
  Route::get('/general-settings/cod/{status}', 'Admin\GeneralSettingController@cod')->name('admin-gs-cod');
  Route::get('/general-settings/paytm/{status}', 'Admin\GeneralSettingController@paytm')->name('admin-gs-paytm');
  Route::get('/general-settings/molly/{status}', 'Admin\GeneralSettingController@molly')->name('admin-gs-molly');
  Route::get('/general-settings/razor/{status}', 'Admin\GeneralSettingController@razor')->name('admin-gs-razor');
  // Payment Gateways

  Route::get('/paymentgateway/datatables', 'Admin\PaymentGatewayController@datatables')->name('admin-payment-datatables'); //JSON REQUEST
  Route::get('/paymentgateway', 'Admin\PaymentGatewayController@index')->name('admin-payment-index');
  Route::get('/paymentgateway/create', 'Admin\PaymentGatewayController@create')->name('admin-payment-create');
  Route::post('/paymentgateway/create', 'Admin\PaymentGatewayController@store')->name('admin-payment-store');
  Route::get('/paymentgateway/edit/{id}', 'Admin\PaymentGatewayController@edit')->name('admin-payment-edit');
  Route::post('/paymentgateway/update/{id}', 'Admin\PaymentGatewayController@update')->name('admin-payment-update');
  Route::get('/paymentgateway/delete/{id}', 'Admin\PaymentGatewayController@destroy')->name('admin-payment-delete');
  Route::get('/paymentgateway/status/{id1}/{id2}/{id3}', 'Admin\PaymentGatewayController@status')->name('admin-payment-status');

  // Currency Settings


  // MULTIPLE CURRENCY

  Route::get('/general-settings/currency/{status}', 'Admin\GeneralSettingController@currency')->name('admin-gs-iscurrency');
  Route::get('/currency/datatables', 'Admin\CurrencyController@datatables')->name('admin-currency-datatables'); //JSON REQUEST
  Route::get('/currency', 'Admin\CurrencyController@index')->name('admin-currency-index');
  Route::get('/currency/create', 'Admin\CurrencyController@create')->name('admin-currency-create');
  Route::post('/currency/create', 'Admin\CurrencyController@store')->name('admin-currency-store');
  Route::get('/currency/edit/{id}', 'Admin\CurrencyController@edit')->name('admin-currency-edit');
  Route::post('/currency/update/{id}', 'Admin\CurrencyController@update')->name('admin-currency-update');
  Route::get('/currency/delete/{id}', 'Admin\CurrencyController@destroy')->name('admin-currency-delete');
  Route::get('/currency/status/{id1}/{id2}', 'Admin\CurrencyController@status')->name('admin-currency-status');


  // -------------------- Reward Section Route ---------------------//
  Route::get('rewards/datatables','Admin\RewardController@datatables')->name('admin-reward-datatables');
  Route::get('rewards','Admin\RewardController@index')->name('admin-reward-index');
  Route::post('reward/update/','Admin\RewardController@update')->name('admin-reward-update');
  Route::post('reward/information/update','Admin\RewardController@infoUpdate')->name('admin-reward-info-update');

  // -------------------- Reward Section Route ---------------------//


  });

  //------------ ADMIN PAYMENT SETTINGS SECTION ENDS------------





  //------------ ADMIN SOCIAL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:social_settings'],function(){

  Route::get('/social', 'Admin\SocialSettingController@index')->name('admin-social-index');
  Route::post('/social/update', 'Admin\SocialSettingController@socialupdate')->name('admin-social-update');
  Route::post('/social/update/all', 'Admin\SocialSettingController@socialupdateall')->name('admin-social-update-all');
  Route::get('/social/facebook', 'Admin\SocialSettingController@facebook')->name('admin-social-facebook');
  Route::get('/social/google', 'Admin\SocialSettingController@google')->name('admin-social-google');
  Route::get('/social/facebook/{status}', 'Admin\SocialSettingController@facebookup')->name('admin-social-facebookup');
  Route::get('/social/google/{status}', 'Admin\SocialSettingController@googleup')->name('admin-social-googleup');


  });
  //------------ ADMIN SOCIAL SETTINGS SECTION ENDS------------



  //------------ ADMIN LANGUAGE SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:language_settings'],function(){

  //  Multiple Language Section

  Route::get('/general-settings/language/{status}', 'Admin\GeneralSettingController@language')->name('admin-gs-islanguage');

  //  Multiple Language Section Ends

  Route::get('/languages/datatables', 'Admin\LanguageController@datatables')->name('admin-lang-datatables'); //JSON REQUEST
  Route::get('/languages', 'Admin\LanguageController@index')->name('admin-lang-index');
  Route::get('/languages/create', 'Admin\LanguageController@create')->name('admin-lang-create');
  Route::get('/languages/edit/{id}', 'Admin\LanguageController@edit')->name('admin-lang-edit');
  Route::post('/languages/create', 'Admin\LanguageController@store')->name('admin-lang-store');
  Route::post('/languages/edit/{id}', 'Admin\LanguageController@update')->name('admin-lang-update');
  Route::get('/languages/status/{id1}/{id2}', 'Admin\LanguageController@status')->name('admin-lang-st');
  Route::get('/languages/delete/{id}', 'Admin\LanguageController@destroy')->name('admin-lang-delete');


  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ------------

  Route::get('/adminlanguages/datatables', 'Admin\AdminLanguageController@datatables')->name('admin-tlang-datatables'); //JSON REQUEST
  Route::get('/adminlanguages', 'Admin\AdminLanguageController@index')->name('admin-tlang-index');
  Route::get('/adminlanguages/create', 'Admin\AdminLanguageController@create')->name('admin-tlang-create');
  Route::get('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@edit')->name('admin-tlang-edit');
  Route::post('/adminlanguages/create', 'Admin\AdminLanguageController@store')->name('admin-tlang-store');
  Route::post('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@update')->name('admin-tlang-update');
  Route::get('/adminlanguages/status/{id1}/{id2}', 'Admin\AdminLanguageController@status')->name('admin-tlang-st');
  Route::get('/adminlanguages/delete/{id}', 'Admin\AdminLanguageController@destroy')->name('admin-tlang-delete');

  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ENDS ------------

  //------------ ADMIN LANGUAGE SETTINGS SECTION ENDS ------------

  });

  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:seo_tools'],function(){

  Route::get('/seotools/analytics', 'Admin\SeoToolController@analytics')->name('admin-seotool-analytics');
  Route::post('/seotools/analytics/update', 'Admin\SeoToolController@analyticsupdate')->name('admin-seotool-analytics-update');
  Route::get('/seotools/keywords', 'Admin\SeoToolController@keywords')->name('admin-seotool-keywords');
  Route::post('/seotools/keywords/update', 'Admin\SeoToolController@keywordsupdate')->name('admin-seotool-keywords-update');
  Route::get('/products/popular/{id}','Admin\SeoToolController@popular')->name('admin-prod-popular');

  Route::get('/facebook/pixel', 'Admin\SeoToolController@pixels')->name('admin-seotool-pixels');
  Route::post('/facebook/pixel/update', 'Admin\SeoToolController@pixelsupdate')->name('admin-seotool-pixels-update');


  });

  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  //------------ ADMIN STAFF SECTION ------------

  Route::group(['middleware'=>'permissions:manage_staffs'],function(){

  Route::get('/staff/datatables', 'Admin\StaffController@datatables')->name('admin-staff-datatables');
  Route::get('/staff', 'Admin\StaffController@index')->name('admin-staff-index');
  Route::get('/staff/create', 'Admin\StaffController@create')->name('admin-staff-create');
  Route::post('/staff/create', 'Admin\StaffController@store')->name('admin-staff-store');
  Route::get('/staff/edit/{id}', 'Admin\StaffController@edit')->name('admin-staff-edit');
  Route::post('/staff/update/{id}', 'Admin\StaffController@update')->name('admin-staff-update');
  Route::get('/staff/show/{id}', 'Admin\StaffController@show')->name('admin-staff-show');
  Route::get('/staff/delete/{id}', 'Admin\StaffController@destroy')->name('admin-staff-delete');

  });

  //------------ ADMIN STAFF SECTION ENDS------------

  //------------ ADMIN SUBSCRIBERS SECTION ------------

  Route::group(['middleware'=>'permissions:subscribers'],function(){

  Route::get('/subscribers/datatables', 'Admin\SubscriberController@datatables')->name('admin-subs-datatables'); //JSON REQUEST
  Route::get('/subscribers', 'Admin\SubscriberController@index')->name('admin-subs-index');
  Route::get('/subscribers/download', 'Admin\SubscriberController@download')->name('admin-subs-download');

  });

  //------------ ADMIN SUBSCRIBERS ENDS ------------

  // ------------ GLOBAL ----------------------
  Route::post('/general-settings/update/all', 'Admin\GeneralSettingController@generalupdate')->name('admin-gs-update');
  Route::post('/general-settings/update/payment', 'Admin\GeneralSettingController@generalupdatepayment')->name('admin-gs-update-payment');

  // STATUS SECTION
  Route::get('/products/status/{id1}/{id2}', 'Admin\ProductController@status')->name('admin-prod-status');
  // STATUS SECTION ENDS

  // FEATURE SECTION
  Route::get('/products/feature/{id}', 'Admin\ProductController@feature')->name('admin-prod-feature');
  Route::post('/products/feature/{id}', 'Admin\ProductController@featuresubmit')->name('admin-prod-feature');
  // FEATURE SECTION ENDS

  // GALLERY SECTION ------------

  Route::get('/gallery/show', 'Admin\GalleryController@show')->name('admin-gallery-show');
  Route::post('/gallery/store', 'Admin\GalleryController@store')->name('admin-gallery-store');
  Route::get('/gallery/delete', 'Admin\GalleryController@destroy')->name('admin-gallery-delete');

  // GALLERY SECTION ENDS------------

  Route::post('/page-settings/update/all', 'Admin\PageSettingController@update')->name('admin-ps-update');
  Route::post('/page-settings/update/home', 'Admin\PageSettingController@homeupdate')->name('admin-ps-homeupdate');

  // ------------ GLOBAL ENDS ----------------------

  Route::group(['middleware'=>'permissions:super'],function(){



  Route::get('/cache/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->route('admin.dashboard')->with('cache','System Cache Has Been Removed.');
  })->name('admin-cache-clear');

  Route::get('/check/movescript', 'Admin\DashboardController@movescript')->name('admin-move-script');
  Route::get('/generate/backup', 'Admin\DashboardController@generate_bkup')->name('admin-generate-backup');
  Route::get('/activation', 'Admin\DashboardController@activation')->name('admin-activation-form');
  Route::post('/activation', 'Admin\DashboardController@activation_submit')->name('admin-activate-purchase');
  Route::get('/clear/backup', 'Admin\DashboardController@clear_bkup')->name('admin-clear-backup');

  // ------------ ROLE SECTION ----------------------

  Route::get('/role/datatables', 'Admin\RoleController@datatables')->name('admin-role-datatables');
  Route::get('/role', 'Admin\RoleController@index')->name('admin-role-index');
  Route::get('/role/create', 'Admin\RoleController@create')->name('admin-role-create');
  Route::post('/role/create', 'Admin\RoleController@store')->name('admin-role-store');
  Route::get('/role/edit/{id}', 'Admin\RoleController@edit')->name('admin-role-edit');
  Route::post('/role/edit/{id}', 'Admin\RoleController@update')->name('admin-role-update');
  Route::get('/role/delete/{id}', 'Admin\RoleController@destroy')->name('admin-role-delete');

  // ------------ ROLE SECTION ENDS ----------------------


  });


});

// ************************************ ADMIN SECTION ENDS**********************************************



//************************************* DELIVERY BOY SECTION*****************************************

Route::prefix('delivery')->group(function() {  
  Route::get('/login', 'Delivery\LoginController@showLoginForm')->name('delivery.login');
  Route::post('/login', 'Delivery\LoginController@login')->name('delivery.login.submit');
  
  Route::get('/logout', 'Delivery\LoginController@logout')->name('delivery.logout');

  //------------ Delivery DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Delivery\DashboardController@index')->name('delivery.dashboard');
  Route::get('/profile', 'Delivery\DashboardController@profile')->name('delivery.profile');
  Route::post('/profile/update', 'Delivery\DashboardController@profileupdate')->name('delivery.profile.update');

  Route::get('/check-delivery-order', 'Delivery\DashboardController@checkdeliveryorder')->name('delivery.check-delivery-order');
  //------------ Delivery DASHBOARD & PROFILE SECTION ENDS ------------
  //------------ Delivery ORDER SECTION ------------

  
  Route::get('/orders/datatables/{slug}', 'Delivery\OrderController@datatables')->name('delivery-order-datatables'); //JSON REQUEST
  
  Route::get('/order/edit/{id}', 'Delivery\OrderController@edit')->name('delivery-order-edit');
  Route::post('/order/update/{id}', 'Delivery\OrderController@update')->name('delivery-order-update');
  Route::get('/orders/pending', 'Delivery\OrderController@pending')->name('delivery-order-pending');
  Route::get('/orders/delivered', 'Delivery\OrderController@delivered')->name('delivery-order-delivered');
  Route::get('/orders/completed', 'Delivery\OrderController@completed')->name('delivery-order-completed');
  Route::get('/order/{id}/show', 'Delivery\OrderController@show')->name('delivery-order-show');
  Route::get('/order/{id1}/status/{status}', 'Delivery\OrderController@status')->name('delivery-order-status');
  
  

  
    
  
  //------------ Delivery ORDER SECTION ENDS------------
  //------------ Delivery CUSTOM TEA ORDER SECTION ------------


  Route::get('/orders/customtea/datatables/{slug}', 'Delivery\CustomTeaOrderController@datatables')->name('delivery-customtea-order-datatables'); //JSON REQUEST
  
  Route::get('/order/customtea/edit/{id}', 'Delivery\CustomTeaOrderController@edit')->name('delivery-customtea-order-edit');
  Route::post('/order/customtea/update/{id}', 'Delivery\CustomTeaOrderController@update')->name('delivery-customtea-order-update');
  Route::get('/orders/customtea/pending', 'Delivery\CustomTeaOrderController@pending')->name('delivery-customtea-order-pending');
  Route::get('/orders/customtea/delivered', 'Delivery\CustomTeaOrderController@delivered')->name('delivery-customtea-order-delivered');
  Route::get('/orders/customtea/completed', 'Delivery\CustomTeaOrderController@completed')->name('delivery-customtea-order-completed');
  Route::get('/order/customtea/{id}/show', 'Delivery\CustomTeaOrderController@show')->name('delivery-customtea-order-show');
  Route::get('/order/customtea/{id1}/status/{status}', 'Delivery\CustomTeaOrderController@status')->name('delivery-customtea-order-status');
  

  Route::get('/total-sold/customtea/', 'Delivery\CustomTeaOrderController@total_sold_order')->name('delivery-customtea-total-sold-order');
  Route::post('/total-sold/customtea/count', 'Delivery\CustomTeaOrderController@total_sold_order_count')->name('delivery-customtea-total-sold-order-count');
  
    
    
  
  //------------ Delivery CUSTOM TEA ORDER SECTION ENDS------------
});

//************************************** END DELIVERY SECTION ******************************

//************************************* SALES MODULE SECTION*****************************************
Route::prefix('sales')->group(function() {  
  Route::get('/login', 'Sales\LoginController@showLoginForm')->name('sales.login');
  Route::post('/login', 'Sales\LoginController@login')->name('sales.login.submit');
  
  Route::get('/logout', 'Sales\LoginController@logout')->name('sales.logout');
  //------------ Delivery DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Sales\DashboardController@index')->name('sales.dashboard');
  Route::get('/profile', 'Sales\DashboardController@profile')->name('sales.profile');
  Route::post('/profile/update', 'Sales\DashboardController@profileupdate')->name('sales.profile.update');

  
  Route::get('/orders/datatables/{slug}', 'Sales\OrderController@datatables')->name('sales-order-datatables'); //JSON REQUEST
  Route::get('/orders', 'Sales\OrderController@index')->name('sales-order-index');
  Route::get('/orders/create', 'Sales\OrderController@create')->name('sales-order-create');
  Route::post('/orders/store', 'Sales\OrderController@store')->name('sales-order-store');
  Route::get('/load/product/', 'Sales\OrderController@load')->name('sales-product-load'); //JSON REQUEST
  Route::get('/order/{id}/show', 'Sales\OrderController@show')->name('sales-order-show');
  Route::get('/order/checkout', 'Sales\OrderController@checkout')->name('sales-order-checkout');
  Route::get('/order/payreturn', 'Sales\OrderController@payreturn')->name('sales-order-payreturn');
  Route::get('/user/wallet/check','Sales\OrderController@walletcheck');
  Route::post('/order/cashondelivery', 'Sales\OrderController@cashondelivery')->name('sales.cod.submit');

  Route::get('/orders/customtea/datatables/{slug}', 'Sales\CustomTeaOrderController@datatables')->name('sales-customtea-order-datatables'); //JSON REQUEST
  Route::get('/orders/customtea', 'Sales\CustomTeaOrderController@index')->name('sales-customtea-order-index');
  Route::get('/orders/customtea/create', 'Sales\CustomTeaOrderController@create')->name('sales-customtea-order-create');
  Route::post('/orders/customtea/store', 'Sales\CustomTeaOrderController@store')->name('sales-customtea-order-store');
  Route::get('/usercustomteacheck','Sales\CustomTeaOrderController@usercustomteacheck');
  Route::get('/order/customtea/{id}/show', 'Sales\CustomTeaOrderController@show')->name('sales-customtea-order-show');
  Route::get('/order/customtea/checkout', 'Sales\CustomTeaOrderController@checkout')->name('sales-customtea-order-checkout');
  Route::get('/order/customtea/payreturn', 'Sales\CustomTeaOrderController@payreturn')->name('sales-customtea-order-payreturn');
  Route::post('/order/customtea/cashondelivery', 'Sales\CustomTeaOrderController@cashondelivery')->name('sales.customtea.cod.submit');
  

  Route::get('/users/datatables/{slug}', 'Sales\UserController@datatables')->name('sales-user-datatables'); //JSON REQUEST
  Route::get('/users', 'Sales\UserController@index')->name('sales-user-index');
  Route::get('/domestic-users', 'Sales\UserController@domestic_user')->name('sales-domestic-user');
  Route::get('/commercial-users', 'Sales\UserController@commercial_user')->name('sales-commercial-user');
  Route::get('/users/registered', 'Sales\UserController@registered')->name('sales-user-registered');
  Route::get('/user/{id}/show', 'Sales\UserController@show')->name('sales-user-show');
  Route::get('/user/create', 'Sales\UserController@create')->name('sales-user-create');
  Route::post('/user/store', 'Sales\UserController@store')->name('sales-user-store');
  
  Route::get('/user/resend-otp','Sales\UserController@resend_otp')->name('sales-user-resendotp');
  // User Register End
  Route::post('/user/otp-submit', 'Sales\UserController@otpcreateuser')->name('sales-user-otp-submit');
  
  Route::get('/user/edit/{id}', 'Sales\UserController@edit')->name('sales-user-edit');
  Route::post('/user/edit/{id}', 'Sales\UserController@update')->name('sales-user-update');
    
  
  
});
//************************************** END SALES MODULE SECTION ******************************


// ************************************ USER SECTION **********************************************

Route::prefix('user')->group(function() {

  // User Dashboard
  Route::get('/dashboard', 'User\UserController@index')->name('user-dashboard');

  Route::get('/customtea-cart', 'User\UserController@user_customtea')->name('user-customtea');

  // User Login
  Route::get('/login', 'User\LoginController@showLoginForm')->name('user.login');
  Route::post('/login', 'User\LoginController@login')->name('user.login.submit');

  Route::get('/resendotplogin','User\LoginController@resend_otp')->name('user-resendotp-login');
  // User Login End
  Route::post('/otplogin', 'User\LoginController@Otplogin')->name('user.otplogin.submit');

  // User Register
  Route::get('/register', 'User\RegisterController@showRegisterForm')->name('user.register');
  Route::post('/register', 'User\RegisterController@register')->name('user-register-submit');

  Route::get('/resendotpregister','User\RegisterController@resend_otp')->name('user-resendotp-register');
  // User Register End
  Route::post('/otpregister', 'User\RegisterController@Otpregister')->name('user.otpregister.submit');
  Route::get('/register/verify/{token}', 'User\RegisterController@token')->name('user-register-token');
  // User Register End

  // User Reset
  Route::get('/reset', 'User\UserController@resetform')->name('user-reset');
  Route::post('/reset', 'User\UserController@reset')->name('user-reset-submit');
  // User Reset End

  // User Profile
  Route::get('/profile', 'User\UserController@profile')->name('user-profile');
  Route::post('/profile', 'User\UserController@profileupdate')->name('user-profile-update');
  // User Profile Ends

  // User Forgot
  Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
  Route::post('/forgot', 'User\ForgotController@forgot')->name('user-forgot-submit');
  // User Forgot Ends

  // User Wishlist
  Route::get('/wishlists','User\WishlistController@wishlists')->name('user-wishlists');
  Route::get('/wishlist/add/{id}','User\WishlistController@addwish')->name('user-wishlist-add');
  Route::get('/wishlist/remove/{id}','User\WishlistController@removewish')->name('user-wishlist-remove');
  // User Wishlist Ends

  // User Review
  Route::post('/review/submit','User\UserController@reviewsubmit')->name('front.review.submit');
  // User Review Ends

  // User Orders

  Route::get('/orders', 'User\OrderController@orders')->name('user-orders');
  Route::get('/order/tracking', 'User\OrderController@ordertrack')->name('user-order-track');
  Route::get('/order/trackings/{id}', 'User\OrderController@trackload')->name('user-order-track-search');
  Route::get('/order/{id}', 'User\OrderController@order')->name('user-order');
  Route::get('/order/cancel/request/{id}', 'User\OrderController@orderCancel')->name('user-order-cancel');
  Route::post('/order/refund/request', 'User\OrderController@orderRefund')->name('user.order.refund.submit');
  Route::get('/order/refund/cancel/{order_number}', 'User\OrderController@cancelRefund')->name('user.refund.cancel');
  Route::get('/download/order/{slug}/{id}', 'User\OrderController@orderdownload')->name('user-order-download');
  Route::get('print/order/print/{id}', 'User\OrderController@orderprint')->name('user-order-print');
  Route::get('/json/trans','User\OrderController@trans');

  // User Orders Ends

  // User Custom Tea Orders

  Route::get('/customtea-orders', 'User\CustomTeaOrderController@orders')->name('user-customtea-orders');
  Route::get('/customtea-order/{id}', 'User\CustomTeaOrderController@order')->name('user-customtea-order');
  Route::get('/customtea-order/cancel/request/{id}', 'User\CustomTeaOrderController@orderCancel')->name('user-customtea-order-cancel');
  Route::post('/customtea-order/refund/request', 'User\CustomTeaOrderController@orderRefund')->name('user.customtea-order.refund.submit');
  Route::get('/customtea-order/refund/cancel/{order_number}', 'User\CustomTeaOrderController@cancelRefund')->name('user.customtea-refund.cancel');
  Route::get('/download/customtea-order/{slug}/{id}', 'User\CustomTeaOrderController@orderdownload')->name('user-customtea-order-download');
  Route::get('print/customtea-order/print/{id}', 'User\CustomTeaOrderController@orderprint')->name('user-customtea-order-print');
  Route::get('/customtea/json/trans','User\CustomTeaOrderController@trans');
  Route::get('/customtea/review/{id}', 'User\CustomTeaOrderController@review')->name('user-customtea-review');
  Route::post('/customtea/review/submit', 'User\CustomTeaOrderController@reviewsubmit')->name('user-customtea-review-submit');
  // User Custom Tea Orders Ends

  // User Subscription

  Route::get('/package', 'User\UserController@package')->name('user-package');
  Route::get('/subscription/{id}', 'User\UserController@vendorrequest')->name('user-vendor-request');
  Route::post('/vendor-request', 'User\UserController@vendorrequestsub')->name('user-vendor-request-submit');
  Route::get('/payment/{slug1}/{slug2}','User\UserController@loadpayment')->name('user.load.payment');
  Route::get('/shop/check', 'User\UserController@check')->name('user.shop.check');

  Route::post('/paypal/submit', 'User\PaypalController@store')->name('user.paypal.submit');
  Route::get('/paypal/cancle', 'User\PaypalController@paycancle')->name('user.payment.cancle');
  Route::get('/paypal/return', 'User\PaypalController@payreturn')->name('user.payment.return');
  Route::get('/paypal/notify', 'User\PaypalController@notify')->name('user.payment.notify');
  Route::post('/stripe/submit', 'User\StripeController@store')->name('user.stripe.submit');

  Route::get('/instamojo/notify', 'User\InstamojoController@notify')->name('user.instamojo.notify');
  Route::post('/instamojo/submit', 'User\InstamojoController@store')->name('user.instamojo.submit');
 // SSLCommerz
 Route::post('/ssl-submit', 'Payment\Subscription\SslController@store')->name('user.ssl.submit');
 Route::post('/ssl-notify', 'Payment\Subscription\SslController@notify')->name('user.ssl.notify');


  Route::get('/molly/notify', 'User\MollyController@notify')->name('user.molly.notify');
  Route::post('/molly/submit', 'User\MollyController@store')->name('user.molly.submit');

  Route::get('/paystack/check', 'User\PaystackController@check')->name('user.paystack.check');
  Route::post('/paystack/submit', 'User\PaystackController@store')->name('user.paystack.submit');

  //PayTM Routes
  Route::post('/paytm/submit', 'User\PaytmController@store')->name('user.paytm.submit');;
  Route::post('/paytm/notify', 'User\PaytmController@notify')->name('user.paytm.notify');
  //Authorize Routes
  Route::post('/authorize-submit', 'User\AuthorizeController@store')->name('user.authorize.submit');

  // Mercadopago Routes
  Route::post('/mercadopago/submit', 'User\MercadopagoController@store')->name('user.mercadopago.submit');

  Route::get('/voguepay/check', 'User\VoguepayController@check')->name('user.voguepay.check');
  Route::post('/voguepay/submit', 'User\VoguepayController@store')->name('user.voguepay.submit');

  // ssl Routes
  Route::post('/ssl/submit', 'User\SslController@store')->name('user.ssl.submit');
  Route::post('/ssl/notify', 'User\SslController@notify')->name('user.ssl.notify');
  Route::post('/ssl/cancle', 'User\SslController@cancle')->name('user.ssl.cancle');


  //PayTM Routes
  Route::post('/razorpay/submit', 'User\RazorpayController@store')->name('user.razorpay.submit');
  Route::post('/razorpay/notify', 'User\RazorpayController@notify')->name('user.razorpay.notify');

  // Flutterwave Routes
  Route::post('/flutter/payment/submit', 'User\FlutterController@store')->name('user.flutter.submit');
  Route::post('/flutter/payment/notify', 'User\FlutterController@notify')->name('user.flutter.notify');

  // User Subscription Ends

  // Deposit Section
  Route::get('/deposit/transactions', 'User\DepositController@transactions')->name('user-transactions-index');
  Route::get('/deposit/transactions/{id}/show', 'User\DepositController@transhow')->name('user-trans-show');
  Route::get('/deposit/index', 'User\DepositController@index')->name('user-deposit-index');
  Route::get('/deposit/create', 'User\DepositController@create')->name('user-deposit-create');
  Route::post('/deposit/paypal/submit', 'User\DpaypalController@store')->name('deposit.paypal.submit');
  Route::get('/deposit/paypal/cancle', 'User\DpaypalController@paycancle')->name('deposit.paypal.cancle');
  Route::get('/deposit/paypal/return', 'User\DpaypalController@payreturn')->name('deposit.paypal.return');
  Route::get('/deposit/paypal/notify', 'User\DpaypalController@notify')->name('deposit.paypal.notify');
  Route::post('/deposit/stripe/submit', 'User\DstripeController@store')->name('deposit.stripe.submit');
  Route::post('/deposit/paystack/submit', 'User\DpaystackController@store')->name('deposit.paystack.submit');
  Route::post('/deposit/voguepay/submit', 'User\DvoguepayController@store')->name('deposit.voguepay.submit');

  //PayTM Routes
  Route::post('/deposit/paytm/submit', 'User\DpaytmController@store')->name('deposit.paytm.submit');
  Route::post('/deposit/paytm/notify', 'User\DpaytmController@notify')->name('deposit.paytm.notify');

  //Razorpay Routes
  Route::post('/deposit/razorpay/submit', 'User\DrazorpayController@store')->name('deposit.razorpay.submit');
  Route::post('/deposit/razorpay/notify', 'User\DrazorpayController@notify')->name('deposit.razorpay.notify');

  //Instamojo Routes
  Route::get('/deposit/instamojo/notify', 'User\DinstamojoController@notify')->name('deposit.instamojo.notify');
  Route::post('/deposit/instamojo/submit', 'User\DinstamojoController@store')->name('deposit.instamojo.submit');

  // SSLCommerz
  Route::post('/deposit/ssl-submit', 'Payment\Deposit\SslController@store')->name('deposit.ssl.submit');
  Route::post('/deposit/ssl-notify', 'Payment\Deposit\SslController@notify')->name('deposit.ssl.notify');

  //Molly Routes
  Route::get('/deposit/molly/notify', 'User\DmollyController@notify')->name('deposit.molly.notify');
  Route::post('/deposit/molly/submit', 'User\DmollyController@store')->name('deposit.molly.submit');



  // ssl Routes
  Route::post('/deposit/ssl/submit', 'User\DsslController@store')->name('deposit.ssl.submit');
  Route::post('/deposit/ssl/notify', 'User\DsslController@notify')->name('deposit.ssl.notify');
  Route::post('/deposit/ssl/cancle', 'User\DsslController@cancle')->name('deposit.ssl.cancle');
  //Authorize Routes
  Route::post('/deposit-authorize-submit', 'User\DauthorizeController@store')->name('deposit.authorize.submit');

  // Mercadopago Routes
  Route::get('/deposit/mercadopago/cancle', 'User\DmercadopagoController@paycancle')->name('deposit.mercadopago.cancle');
  Route::get('/deposit/mercadopago/return', 'User\DmercadopagoController@payreturn')->name('deposit.mercadopago.return');
  Route::post('/deposit/mercadopago/notify', 'User\DmercadopagoController@notify')->name('deposit.mercadopago.notify');
  Route::post('/deposit/mercadopago/submit', 'User\DmercadopagoController@store')->name('deposit.mercadopago.submit');

  // Flutterwave Routes
  Route::post('/deposit/flutter/submit', 'User\DflutterController@store')->name('deposit.flutter.submit');
  Route::post('/deposit/flutter/notify', 'User\DflutterController@notify')->name('deposit.flutter.notify');


  //2checkout Routes
  Route::post('/deposit/twocheckout-submit', 'User\DtwoCheckoutController@store')->name('deposit.twocheckout.submit');


  // Deposit Section Ends







  // User Vendor Send Message

  Route::post('/user/contact', 'User\MessageController@usercontact');
  Route::get('/messages', 'User\MessageController@messages')->name('user-messages');
  Route::get('/message/{id}', 'User\MessageController@message')->name('user-message');
  Route::post('/message/post', 'User\MessageController@postmessage')->name('user-message-post');
  Route::get('/message/{id}/delete', 'User\MessageController@messagedelete')->name('user-message-delete');
  Route::get('/message/load/{id}', 'User\MessageController@msgload')->name('user-vendor-message-load');

  // User Vendor Send Message Ends


  //  --------------------- Reward Point Route ------------------------------//
  Route::get('reward/points','User\RewardController@rewards')->name('user-reward-index');
  Route::get('reward/convert','User\RewardController@convert')->name('user-reward-convernt');
  Route::post('reward/convert/submit','User\RewardController@convertSubmit')->name('user-reward-convert-submit');




  // User Admin Send Message


  // Tickets
  Route::get('admin/tickets', 'User\MessageController@adminmessages')->name('user-message-index');
  // Disputes
  Route::get('admin/disputes', 'User\MessageController@adminDiscordmessages')->name('user-dmessage-index');

  Route::get('admin/message/{id}', 'User\MessageController@adminmessage')->name('user-message-show');
  
  Route::post('admin/message/post', 'User\MessageController@adminpostmessage')->name('user-message-store');
  Route::get('admin/message/{id}/delete', 'User\MessageController@adminmessagedelete')->name('user-message-delete1');
  Route::post('admin/user/send/message', 'User\MessageController@adminusercontact')->name('user-send-message');
  Route::get('admin/message/load/{id}', 'User\MessageController@messageload')->name('user-message-load');
  // User Admin Send Message Ends


  Route::get('/affilate/code', 'User\WithdrawController@affilate_code')->name('user-affilate-code');
  Route::get('/affilate/withdraw', 'User\WithdrawController@index')->name('user-wwt-index');
  Route::get('/affilate/withdraw/create', 'User\WithdrawController@create')->name('user-wwt-create');
  Route::post('/affilate/withdraw/create', 'User\WithdrawController@store')->name('user-wwt-store');

  // User Favorite Seller

  Route::get('/favorite/seller', 'User\UserController@favorites')->name('user-favorites');
  Route::get('/favorite/{id1}/{id2}', 'User\UserController@favorite')->name('user-favorite');
  Route::get('/favorite/seller/{id}/delete', 'User\UserController@favdelete')->name('user-favorite-delete');

  // User Favorite Seller Ends

  // User Logout
  Route::get('/logout', 'User\LoginController@logout')->name('user-logout');
  // User Logout Ends

});

// ************************************ USER SECTION ENDS**********************************************





  Route::get('/under-maintenance', 'Front\FrontendController@maintenance')->name('front-maintenance');


  Route::group(['middleware'=>'maintenance'],function(){

// ************************************ VENDOR SECTION **********************************************


Route::prefix('vendor')->group(function() {


  Route::group(['middleware'=>'vendor'],function(){
  // Vendor Dashboard
  Route::get('/dashboard', 'Vendor\VendorController@index')->name('vendor-dashboard');


    //IMPORT SECTION
    Route::get('/products/import/create', 'Vendor\ImportController@createImport')->name('vendor-import-create');
    Route::get('/products/import/edit/{id}', 'Vendor\ImportController@edit')->name('vendor-import-edit');
    Route::get('/products/import/csv', 'Vendor\ImportController@importCSV')->name('vendor-import-csv');
    Route::get('/products/import/datatables', 'Vendor\ImportController@datatables')->name('vendor-import-datatables');
    Route::get('/products/import/index', 'Vendor\ImportController@index')->name('vendor-import-index');
    Route::post('/products/import/store', 'Vendor\ImportController@store')->name('vendor-import-store');
    Route::post('/products/import/update/{id}', 'Vendor\ImportController@update')->name('vendor-import-update');
    Route::post('/products/import/csv/store', 'Vendor\ImportController@importStore')->name('vendor-import-csv-store');
    //IMPORT SECTION


  //------------ ADMIN ORDER SECTION ------------
  Route::get('/orders', 'Vendor\OrderController@index')->name('vendor-order-index');
  Route::get('/order/{id}/show', 'Vendor\OrderController@show')->name('vendor-order-show');
  Route::get('/order/{id}/invoice', 'Vendor\OrderController@invoice')->name('vendor-order-invoice');
  Route::get('/order/{id}/print', 'Vendor\OrderController@printpage')->name('vendor-order-print');
  Route::get('/order/{id1}/status/{status}', 'Vendor\OrderController@status')->name('vendor-order-status');
  Route::post('/order/email/', 'Vendor\OrderController@emailsub')->name('vendor-order-emailsub');
  Route::post('/order/{slug}/license', 'Vendor\OrderController@license')->name('vendor-order-license');

  //------------ ADMIN CATEGORY SECTION ENDS------------


  //------------ VENDOR SUBCATEGORY SECTION ------------

  Route::get('/load/subcategories/{id}/', 'Vendor\VendorController@subcatload')->name('vendor-subcat-load'); //JSON REQUEST

  //------------ VENDOR SUBCATEGORY SECTION ENDS------------

  //------------ VENDOR CHILDCATEGORY SECTION ------------

  Route::get('/load/childcategories/{id}/', 'Vendor\VendorController@childcatload')->name('vendor-childcat-load'); //JSON REQUEST

  //------------ VENDOR CHILDCATEGORY SECTION ENDS------------

  //------------ VENDOR PRODUCT SECTION ------------

  Route::get('/products/datatables', 'Vendor\ProductController@datatables')->name('vendor-prod-datatables'); //JSON REQUEST
  Route::get('/products', 'Vendor\ProductController@index')->name('vendor-prod-index');

  Route::post('/products/upload/update/{id}', 'Vendor\ProductController@uploadUpdate')->name('vendor-prod-upload-update');

  // CREATE SECTION
  Route::get('/products/types', 'Vendor\ProductController@types')->name('vendor-prod-types');
  Route::get('/products/physical/create', 'Vendor\ProductController@createPhysical')->name('vendor-prod-physical-create');
  Route::get('/products/digital/create', 'Vendor\ProductController@createDigital')->name('vendor-prod-digital-create');
  Route::get('/products/license/create', 'Vendor\ProductController@createLicense')->name('vendor-prod-license-create');
  Route::post('/products/store', 'Vendor\ProductController@store')->name('vendor-prod-store');
  Route::get('/getattributes', 'Vendor\ProductController@getAttributes')->name('vendor-prod-getattributes');
  Route::get('/products/import', 'Vendor\ProductController@import')->name('vendor-prod-import');
  Route::post('/products/import-submit', 'Vendor\ProductController@importSubmit')->name('vendor-prod-importsubmit');

  Route::get('/products/catalog/datatables', 'Vendor\ProductController@catalogdatatables')->name('admin-vendor-catalog-datatables');
  Route::get('/products/catalogs', 'Vendor\ProductController@catalogs')->name('admin-vendor-catalog-index');

  // CREATE SECTION

  // EDIT SECTION
  Route::get('/products/edit/{id}', 'Vendor\ProductController@edit')->name('vendor-prod-edit');
  Route::post('/products/edit/{id}', 'Vendor\ProductController@update')->name('vendor-prod-update');

  Route::get('/products/catalog/{id}', 'Vendor\ProductController@catalogedit')->name('vendor-prod-catalog-edit');
  Route::post('/products/catalog/{id}', 'Vendor\ProductController@catalogupdate')->name('vendor-prod-catalog-update');

  // EDIT SECTION ENDS

  // STATUS SECTION
  Route::get('/products/status/{id1}/{id2}', 'Vendor\ProductController@status')->name('vendor-prod-status');
  // STATUS SECTION ENDS

  // DELETE SECTION
  Route::get('/products/delete/{id}', 'Vendor\ProductController@destroy')->name('vendor-prod-delete');
  // DELETE SECTION ENDS

  //------------ VENDOR PRODUCT SECTION ENDS------------

  //------------ VENDOR GALLERY SECTION ------------

  Route::get('/gallery/show', 'Vendor\GalleryController@show')->name('vendor-gallery-show');
  Route::post('/gallery/store', 'Vendor\GalleryController@store')->name('vendor-gallery-store');
  Route::get('/gallery/delete', 'Vendor\GalleryController@destroy')->name('vendor-gallery-delete');

  //------------ VENDOR GALLERY SECTION ENDS------------

  //------------ ADMIN SHIPPING ------------

  Route::get('/shipping/datatables', 'Vendor\ShippingController@datatables')->name('vendor-shipping-datatables');
  Route::get('/shipping', 'Vendor\ShippingController@index')->name('vendor-shipping-index');
  Route::get('/shipping/create', 'Vendor\ShippingController@create')->name('vendor-shipping-create');
  Route::post('/shipping/create', 'Vendor\ShippingController@store')->name('vendor-shipping-store');
  Route::get('/shipping/edit/{id}', 'Vendor\ShippingController@edit')->name('vendor-shipping-edit');
  Route::post('/shipping/edit/{id}', 'Vendor\ShippingController@update')->name('vendor-shipping-update');
  Route::get('/shipping/delete/{id}', 'Vendor\ShippingController@destroy')->name('vendor-shipping-delete');

  //------------ ADMIN SHIPPING ENDS ------------


  //------------ ADMIN PACKAGE ------------

  Route::get('/package/datatables', 'Vendor\PackageController@datatables')->name('vendor-package-datatables');
  Route::get('/package', 'Vendor\PackageController@index')->name('vendor-package-index');
  Route::get('/package/create', 'Vendor\PackageController@create')->name('vendor-package-create');
  Route::post('/package/create', 'Vendor\PackageController@store')->name('vendor-package-store');
  Route::get('/package/edit/{id}', 'Vendor\PackageController@edit')->name('vendor-package-edit');
  Route::post('/package/edit/{id}', 'Vendor\PackageController@update')->name('vendor-package-update');
  Route::get('/package/delete/{id}', 'Vendor\PackageController@destroy')->name('vendor-package-delete');


  //------------ ADMIN PACKAGE ENDS------------



  //------------ VENDOR NOTIFICATION SECTION ------------

  // Order Notification
  Route::get('/order/notf/show/{id}', 'Vendor\NotificationController@order_notf_show')->name('vendor-order-notf-show');
  Route::get('/order/notf/count/{id}','Vendor\NotificationController@order_notf_count')->name('vendor-order-notf-count');
  Route::get('/order/notf/clear/{id}','Vendor\NotificationController@order_notf_clear')->name('vendor-order-notf-clear');
  // Order Notification Ends

  // Product Notification Ends

  //------------ VENDOR NOTIFICATION SECTION ENDS ------------

  // Vendor Profile
  Route::get('/profile', 'Vendor\VendorController@profile')->name('vendor-profile');
  Route::post('/profile', 'Vendor\VendorController@profileupdate')->name('vendor-profile-update');
  // Vendor Profile Ends

  // Vendor Shipping Cost
  Route::get('/shipping-cost', 'Vendor\VendorController@ship')->name('vendor-shop-ship');

  // Vendor Shipping Cost
  Route::get('/banner', 'Vendor\VendorController@banner')->name('vendor-banner');

  // Vendor Social
  Route::get('/social', 'Vendor\VendorController@social')->name('vendor-social-index');
  Route::post('/social/update', 'Vendor\VendorController@socialupdate')->name('vendor-social-update');

  Route::get('/withdraw/datatables', 'Vendor\WithdrawController@datatables')->name('vendor-wt-datatables');
  Route::get('/withdraw', 'Vendor\WithdrawController@index')->name('vendor-wt-index');
  Route::get('/withdraw/create', 'Vendor\WithdrawController@create')->name('vendor-wt-create');
  Route::post('/withdraw/create', 'Vendor\WithdrawController@store')->name('vendor-wt-store');


  Route::get('/slider/datatables', 'Vendor\SliderController@datatables')->name('vendor-slider-datatables');
  Route::get('/slider', 'Vendor\SliderController@index')->name('vendor-slider-index');
  Route::get('/slider/create', 'Vendor\SliderController@create')->name('vendor-slider-create');
  Route::post('/slider/create', 'Vendor\SliderController@store')->name('vendor-slider-store');
  Route::get('/slider/edit/{id}', 'Vendor\SliderController@edit')->name('vendor-slider-edit');
  Route::post('/slider/edit/{id}', 'Vendor\SliderController@update')->name('vendor-slider-update');
  Route::get('/slider/delete/{id}', 'Vendor\SliderController@destroy')->name('vendor-slider-delete');

  Route::get('/service/datatables', 'Vendor\ServiceController@datatables')->name('vendor-service-datatables');
  Route::get('/service', 'Vendor\ServiceController@index')->name('vendor-service-index');
  Route::get('/service/create', 'Vendor\ServiceController@create')->name('vendor-service-create');
  Route::post('/service/create', 'Vendor\ServiceController@store')->name('vendor-service-store');
  Route::get('/service/edit/{id}', 'Vendor\ServiceController@edit')->name('vendor-service-edit');
  Route::post('/service/edit/{id}', 'Vendor\ServiceController@update')->name('vendor-service-update');
  Route::get('/service/delete/{id}', 'Vendor\ServiceController@destroy')->name('vendor-service-delete');


 Route::get('/verify', 'Vendor\VendorController@verify')->name('vendor-verify');
 Route::get('/warning/verify/{id}', 'Vendor\VendorController@warningVerify')->name('vendor-warning');
 Route::post('/verify', 'Vendor\VendorController@verifysubmit')->name('vendor-verify-submit');

  });

  // -------------------------- Vendor Income ------------------------------------//
  Route::get('earning/datatables',"Vendor\IncomeController@datatables")->name('vendor.income.datatables');
  Route::get('total/earning',"Vendor\IncomeController@index")->name('vendor.income');

});


// ************************************ VENDOR SECTION ENDS**********************************************
Route::group(['middleware'=>'HtmlMinifier'], function(){ 
  


// ************************************ FRONT SECTION **********************************************

  Route::get('/', 'Front\FrontendController@index')->name('front.index');
  Route::get('/extras', 'Front\FrontendController@extraIndex')->name('front.extraIndex');

  Route::get('/currency/{id}', 'Front\FrontendController@currency')->name('front.currency');
  Route::get('/front/get/category', 'Front\FrontendController@getCategory')->name('front.get.category');
  Route::get('/language/{id}', 'Front\FrontendController@language')->name('front.language');

  // BLOG SECTION
  Route::get('/blog','Front\FrontendController@blog')->name('front.blog');
  Route::get('/blog/{id}','Front\FrontendController@blogshow')->name('front.blogshow');
  Route::get('/blog/category/{slug}','Front\FrontendController@blogcategory')->name('front.blogcategory');
  Route::get('/blog/tag/{slug}','Front\FrontendController@blogtags')->name('front.blogtags');
  Route::get('/blog-search','Front\FrontendController@blogsearch')->name('front.blogsearch');
  Route::get('/blog/archive/{slug}','Front\FrontendController@blogarchive')->name('front.blogarchive');
  // BLOG SECTION ENDS

  // FAQ SECTION
  Route::get('/faq','Front\FrontendController@faq')->name('front.faq');
  // FAQ SECTION ENDS
  Route::get('/about','Front\FrontendController@about')->name('front.about');
  // CONTACT SECTION
  Route::get('/contact','Front\FrontendController@contact')->name('front.contact');
  Route::post('/contact','Front\FrontendController@contactemail')->name('front.contact.submit');
  Route::get('/contact/refresh_code','Front\FrontendController@refresh_code');
  // CONTACT SECTION  ENDS

  // PRODCT AUTO SEARCH SECTION
  Route::get('/autosearch/product/{slug}','Front\FrontendController@autosearch');
  Route::get('admin/autosearch/product/{slug}','Front\FrontendController@adminautosearch');
  // PRODCT AUTO SEARCH SECTION ENDS

  // CATEGORY SECTION
  Route::get('/category/{category?}/{subcategory?}/{childcategory?}','Front\CatalogController@category')->name('front.category');
  Route::get('/category/{slug1}/{slug2}','Front\CatalogController@subcategory')->name('front.subcat');
  Route::get('/category/{slug1}/{slug2}/{slug3}','Front\CatalogController@childcategory')->name('front.childcat');
  Route::get('/categories/','Front\CatalogController@categories')->name('front.categories');
  Route::get('/childcategories/{slug}', 'Front\CatalogController@childcategories')->name('front.childcategories');
  // CATEGORY SECTION ENDS

  // TAG SECTION
  Route::get('/tag/{slug}','Front\CatalogController@tag')->name('front.tag');
  // TAG SECTION ENDS

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS



  // PRODCT SECTION
  Route::get('/item/{slug}','Front\CatalogController@product')->name('front.product');
  Route::get('/afbuy/{slug}','Front\CatalogController@affProductRedirect')->name('affiliate.product');
  Route::get('/item/quick/view/{id}/','Front\CatalogController@quick')->name('product.quick');
  Route::get('/item/cross-sell/{id}/','Front\CatalogController@crossSell')->name('product.cross-sell');
  Route::post('/item/review','Front\CatalogController@reviewsubmit')->name('front.review.submit');
  Route::get('/item/view/review/{id}','Front\CatalogController@reviews')->name('front.reviews');
  // PRODCT SECTION ENDS

  // COMMENT SECTION
  Route::post('/item/comment/store', 'Front\CatalogController@comment')->name('product.comment');
  Route::post('/item/comment/edit/{id}', 'Front\CatalogController@commentedit')->name('product.comment.edit');
  Route::get('/item/comment/delete/{id}', 'Front\CatalogController@commentdelete')->name('product.comment.delete');
  // COMMENT SECTION ENDS

  // REPORT SECTION
  Route::post('/item/report', 'Front\CatalogController@report')->name('product.report');
  // REPORT SECTION ENDS


  // COMPARE SECTION
  Route::get('/item/compare/view', 'Front\CompareController@compare')->name('product.compare');
  Route::get('/item/compare/add/{id}', 'Front\CompareController@addcompare')->name('product.compare.add');
  Route::get('/item/compare/remove/{id}', 'Front\CompareController@removecompare')->name('product.compare.remove');
  // COMPARE SECTION ENDS

  // REPLY SECTION
  Route::post('/item/reply/{id}', 'Front\CatalogController@reply')->name('product.reply');
  Route::post('/item/reply/edit/{id}', 'Front\CatalogController@replyedit')->name('product.reply.edit');
  Route::get('/item/reply/delete/{id}', 'Front\CatalogController@replydelete')->name('product.reply.delete');
  // REPLY SECTION ENDS

  // CART SECTION
  Route::get('/carts/view','Front\CartController@cartview');
  Route::get('/carts/','Front\CartController@cart')->name('front.cart');
  Route::get('/addcart/{id}','Front\CartController@addcart')->name('product.cart.add');
  Route::get('/addtocart/{id}','Front\CartController@addtocart')->name('product.cart.quickadd');
  Route::get('/addnumcart','Front\CartController@addnumcart')->name('product.addnum.cart');
  // admin cart
  Route::get('/admin/product/addnumcart','Admin\CartController@addnumcart')->name('admin.product.addnum.cart');
  Route::get('/admin/cart/load','Admin\CartController@admincartload')->name('admin.cart.load');
  Route::get('/admin/removecart/{id}','Admin\CartController@removecart')->name('admin.product.cart.remove');
  Route::get('/admin/addbyone','Admin\CartController@addbyone');
  Route::get('/admin/reducebyone','Admin\CartController@reducebyone');
  Route::get('admin/carts/coupon','Admin\CartController@coupon');
  Route::get('admin/state/get','Admin\CartController@get_state')->name('admin-tax-state-get');
 // admin cart


  Route::get('/addtonumcart','Front\CartController@addtonumcart');
  Route::get('/addbyone','Front\CartController@addbyone');
  Route::get('/reducebyone','Front\CartController@reducebyone');
  Route::get('/upcolor','Front\CartController@upcolor');
  Route::get('/removecart/{id}','Front\CartController@removecart')->name('product.cart.remove');
  Route::get('/carts/coupon','Front\CartController@coupon');
  Route::get('/carts/coupon/check','Front\CartController@couponcheck');
  Route::get('/country/tax/check','Front\CartController@country_tax');
  // CART SECTION ENDS

  // CUSTOM TEA SECTION
  Route::get('/custom-tea','Front\CustomTeaController@customtea')->name('front.customtea');
  Route::post('/custom-tea-submit', 'Front\CustomTeaController@customtea_submit')->name('customtea-submit');
  Route::get('/totalpricecheck','Front\CustomTeaController@totalpricecheck');
  Route::get('/customtea-checkout','Front\CustomTeaCheckoutController@checkout')->name('front.customteacheckout');
  Route::get('/customtea/coupon/check','Front\CustomTeaCheckoutController@couponcheck');

  // CHECKOUT SECTION
  Route::get('/checkout/','Front\CheckoutController@checkout')->name('front.checkout');
  Route::get('/localpincodecheck','Front\CheckoutController@localpincodecheck');
  Route::get('/checkout/payment/{slug1}/{slug2}','Front\CheckoutController@loadpayment')->name('front.load.payment');
  Route::get('/country/wise/state/{country_id}','Front\CheckoutController@getState')->name('country.wise.state');
  Route::get('/order/track/{id}','Front\FrontendController@trackload')->name('front.track.search');
  Route::get('/checkout/payment/return', 'Front\PaymentController@payreturn')->name('payment.return');
  Route::get('/customtea-checkout/payment/return', 'Front\PaymentController@customteapayreturn')->name('customteapayment.return');
  Route::get('/checkout/payment/cancle', 'Front\PaymentController@paycancle')->name('payment.cancle');
  Route::get('/checkout-customtea/payment/cancle', 'Front\PaymentController@customteapaycancle')->name('customteapayment.cancle');
  Route::get('/checkout/payment/notify', 'Front\PaymentController@notify')->name('payment.notify');
  Route::get('/checkout/instamojo/notify', 'Front\InstamojoController@notify')->name('instamojo.notify');

  Route::post('/paystack/submit', 'Front\PaystackController@store')->name('paystack.submit');
  Route::post('/instamojo/submit', 'Front\InstamojoController@store')->name('instamojo.submit');
  Route::post('/paypal-submit', 'Front\PaymentController@store')->name('paypal.submit');
  Route::post('/stripe-submit', 'Front\StripeController@store')->name('stripe.submit');
  Route::post('/authorize-submit', 'Front\AuthorizeController@store')->name('authorize.submit');
  Route::post('/voguepay/submit', 'Front\VoguepayController@store')->name('voguepay.submit');

  //2checkout Routes
  Route::post('/twocheckout-submit', 'Front\TwoCheckoutController@store')->name('twocheckout.submit');


   // ssl Routes
   Route::post('/ssl/submit', 'Front\SslController@store')->name('ssl.submit');
   Route::post('/ssl/notify', 'Front\SslController@notify')->name('ssl.notify');
   Route::post('/ssl/cancle', 'Front\SslController@cancle')->name('ssl.cancle');

   
  Route::post('/flutter/submit', 'Front\FlutterWaveController@store')->name('flutter.submit');
  Route::post('/flutter/notify', 'Front\FlutterWaveController@notify')->name('flutter.notify');
  // Molly Routes

  Route::post('/checkout/molly/submit', 'Front\MollyController@store')->name('molly.submit');
  Route::get('checkout/molly/notify', 'Front\MollyController@notify')->name('front.molly.notify');
  // Molly Routes Ends

    // Mercadopago 
    Route::post('/payment/mercadopago-submit', 'Front\MercadopagoController@store')->name('mercadopago.submit');


   //PayTM Routes
   Route::post('/paytm-submit', 'Front\PaytmController@store')->name('paytm.submit');;
   Route::post('/paytm-callback', 'Front\PaytmController@paytmCallback')->name('paytm.notify');

  //RazorPay Routes
  Route::post('/razorpay-submit', 'Front\RazorpayController@store')->name('razorpay.submit');
  Route::post('/razorpay-customtea-submit', 'Front\RazorpayController@customteastore')->name('razorpaycustomtea.submit');
  Route::post('/razorpay-callback', 'Front\RazorpayController@razorCallback')->name('razorpay.notify');
  Route::post('/razorpay-customtea-callback', 'Front\RazorpayController@customtearazorCallback')->name('razorpaycustomtea.notify');


  Route::post('/cashondelivery', 'Front\CheckoutController@cashondelivery')->name('cod.submit');
  Route::post('/cashondelivery-customtea', 'Front\CustomTeaCheckoutController@cashondelivery')->name('codcustomtea.submit');
  Route::post('/gateway', 'Front\CheckoutController@gateway')->name('manual.submit');
  // CHECKOUT SECTION ENDS
  // WALLET SECTION
  Route::get('/wallet/check','Front\CartController@walletcheck');
  // WALLET SECTION ENDS

  Route::post('/wallet-submit', 'Front\CheckoutController@wallet')->name('wallet.submit');

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS

  // VENDOR SECTION
  Route::get('/store/{category}','Front\VendorController@index')->name('front.vendor');
  Route::post('/vendor/contact','Front\VendorController@vendorcontact');
  // TAG SECTION ENDS

  // SUBSCRIBE SECTION

  Route::post('/subscriber/store', 'Front\FrontendController@subscribe')->name('front.subscribe');

  // SUBSCRIBE SECTION ENDS


  // LOGIN WITH FACEBOOK OR GOOGLE SECTION
  Route::get('auth/{provider}', 'User\SocialRegisterController@redirectToProvider')->name('social-provider');
  Route::get('auth/{provider}/callback', 'User\SocialRegisterController@handleProviderCallback');
  // LOGIN WITH FACEBOOK OR GOOGLE SECTION ENDS

  //  CRONJOB
  Route::get('/vendor/subscription/check','Front\FrontendController@subcheck');
  // CRONJOB ENDS

  // PAGE SECTION
  Route::get('/select/country/wise/state/{country_id}/{user_id}','Front\FrontendController@country_wise_state')->name('select.country.state');
  Route::get('/{slug}','Front\FrontendController@page')->name('front.page');
  // PAGE SECTION ENDS

// ************************************ FRONT SECTION ENDS**********************************************


});

  });

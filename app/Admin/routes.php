<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    //用户列表
    $router->get('users', 'UsersController@index');
    //商品列表
    $router->get('products','ProductsController@index');
    //创建商品
    $router->get('products/create', 'ProductsController@create');
    $router->post('products','ProductsController@store');

    //编辑商品
    $router->get('products/{id}/edit','ProductsController@edit');
    $router->put('products/{id}','ProductsController@update');

    $router->get('orders', 'OrdersController@index')->name('admin.orders.index');
    $router->get('orders/{order}','OrdersController@show')->name('admin.orders.show');
    $router->post('orders/{order}/ship','OrdersController@ship')->name('admin.orders.ship');

    $router->post('orders/{order}/refund','OrdersController@handleRefund')->name('admin.orders.handle_refund');

    //优惠券
    $router->get('coupon_codes','CouponCodesController@index');
    $router->post('coupon_codes','CouponCodesController@store');
    $router->get('coupon_codes/create','CouponCodesController@create');
    $router->get('coupon_codes/{id}/edit','CouponCodesController@edit');
    $router->put('coupon_codes/{id}','CouponCodesController@update');

    //商品类目
    $router->get('categories','CategoriesController@index');
    $router->get('categories/create','CategoriesController@create');
    $router->get('categories/{id}/edit','CategoriesController@edit');
    $router->post('categories','CategoriesController@store');
    $router->put('categories/{id}','CategoriesController@update');
    $router->delete('categories/{id}','CategoriesController@destory');
    $router->get('api/categories','CategoriesController@apiIndex');

    //众筹商品
    $router->get('crowdfunding_products', 'CrowdfundingProductsController@index');
    $router->get('crowdfunding_products/create', 'CrowdfundingProductsController@create');
    $router->post('crowdfunding_products', 'CrowdfundingProductsController@store');
    $router->get('crowdfunding_products/{id}/edit', 'CrowdfundingProductsController@edit');
    $router->put('crowdfunding_products/{id}', 'CrowdfundingProductsController@update');

});

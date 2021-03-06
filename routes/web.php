<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/','PagesController@root')->name('root');
Route::redirect('/','/products')->name('root');
Route::get('products','ProductsController@index')->name('products.index');
Route::get('products/{product}','ProductsController@show')->name('products.show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware'=>['auth']],function(){
    //用户地址列表
    Route::get('user_addresses','UserAddressesController@index')->name('user_addresses.index');
    Route::get('user_addresses/create','UserAddressesController@create')->name('user_addresses.create');
    Route::post('user_addresses','UserAddressesController@store')->name('user_addresses.store');
    Route::get('user_addresses/{user_address}','UserAddressesController@edit')->name('user_addresses.edit');
    Route::put('user_addresses/{user_address}','UserAddressesController@update')->name('user_addresses.update');
    Route::delete('user_addresses/{user_address}','UserAddressesController@destroy')->name('user_addresses.destroy');

    Route::get('products/user/favorites','ProductsController@favorites')->name('products.favorites');
    Route::post('products/{product}/favorite','ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite','ProductsController@disfavor')->name('products.disfavor');

    //购物车-添加商品
    Route::post('cart','CartController@add')->name('cart.add');
    //购物车-列表
    Route::get('cart','CartController@index')->name('cart.index');
    //购物车-删除商品
    Route::delete('cart/{sku}','CartController@remove')->name('cart.remove');

    Route::post('orders','OrdersController@store')->name('orders.store');
    Route::get('orders','OrdersController@index')->name('orders.index');
    Route::get('orders/{order}','OrdersController@show')->name('orders.show');

    Route::get('alipay', function() {
        return app('alipay')->web([
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ]);
    });

});


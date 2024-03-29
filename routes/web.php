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

    Route::get('payment/{order}/alipay','PaymentController@payByAlipay')->name('payment.alipay');
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');

    Route::get('payment/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');
    Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');

    //确认收货
    Route::post('orders/{order}/received','OrdersController@received')->name('orders.received');
    //评价页面
    Route::get('orders/{order}/review','OrdersController@review')->name('orders.review.show');
    //提交评价
    Route::post('orders/{order}/review','OrdersController@sendReview')->name('orders.review.store');

    // 退款申请
    Route::post('orders/{order}/apply_refund','OrdersController@applyRefund')->name('orders.apply_refund');

//    Route::get('alipay', function() {
//        return app('alipay')->web([
//            'out_trade_no' => time(),
//            'total_amount' => '1',
//            'subject' => 'test subject - 测试',
//        ]);
//    });
    // 众筹商品下单
    Route::post('crowdfunding_orders', 'OrdersController@crowdfunding')->name('crowdfunding_orders.store');
    // 分期支付
    Route::post('payment/{order}/installment','PaymentController@payByInstallment')->name('payment.installment');
    // 分期订单列表
    Route::get('installments','InstallmentsController@index')->name('installments.index');
    // 分期订单详情
    Route::get('installments/{installment}','InstallmentsController@show')->name('installments.show');
    Route::get('installments/{installment}/alipay', 'InstallmentsController@payByAlipay')->name('installments.alipay');
    Route::get('installments/alipay/return', 'InstallmentsController@alipayReturn')->name('installments.alipay.return');
    Route::get('installments/{installment}/wechat', 'InstallmentsController@payByWechat')->name('installments.wechat');
});
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
Route::post('payment/wechat/refund_notify','PaymentController@wechatRefundNotify')->name('payment.wechat.refund_notify');
// 后端回调不能放在 auth 中间件中
Route::post('installments/alipay/notify', 'InstallmentsController@alipayNotify')->name('installments.alipay.notify');
Route::post('installments/wechat/notify', 'InstallmentsController@wechatNotify')->name('installments.wechat.notify');
Route::post('installments/wechat/refund_notify', 'InstallmentsController@wechatRefundNotify')->name('installments.wechat.refund_notify');
//优惠券
Route::get('coupon_codes/{code}','CouponCodesController@show')->name('coupon_codes.show');



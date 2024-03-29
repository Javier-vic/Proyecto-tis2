<?php

use App\Http\Controllers\CategorySupplyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\AsistController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ImageMainController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\worker;
use App\Http\Controllers\SendCouponController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\welcomeMail;
use App\Models\product;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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

Route::get('/location', [LandingController::class, 'ubicacion'])->name('location');
Route::get('/getLocation', [LandingController::class, 'getLocation'])->name('getLocation');
Route::get('/', [LandingController::class, 'index']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', [LandingController::class, 'index']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Auth::routes();

Route::middleware(['auth', 'verifyrole'])->group(function () {
    //GET
    Route::get('/coupon/refresh/coupon', [\App\Http\Controllers\CouponController::class, 'refreshCoupons'])->name('coupon.refresh.coupon');
    Route::get('/product/productView', [ProductController::class, 'productView'])->name('product.view');
    Route::get('/product/productModalEdit', [ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/product/productView', [ProductController::class, 'productView'])->name('product.view');
    Route::get('/product/productModalEdit', [ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/category_product/store/category', [CategoryProductController::class, 'store_category_product'])->name('categoryProduct');
    Route::get('/category_product/modal/edit', [CategoryProductController::class, 'categoryProductModalEdit'])->name('category.product.modal.edit');
    Route::get('/roles/permitsofrole', [RoleController::class, 'getPermits'])->name('permits.roles');
    Route::get('/roles/dataTableRole', [RoleController::class, 'dataTable'])->name('dataTable.Roles');
    Route::get('/asist/dataTable', [AsistController::class, 'dataTable'])->name('dataTable.asist');
    Route::get('/product/productModalEdit', [\App\Http\Controllers\ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/product/productView', [\App\Http\Controllers\ProductController::class, 'productView'])->name('product.view');
    Route::get('/worker/dataTable', [worker::class, 'dataTableWorkers'])->name('datatable.workers');
    Route::get('/worker/getWorker', [worker::class, 'getWorker'])->name('worker.getWorker');
    Route::get('/order/GetSaleMonth', [\App\Http\Controllers\OrderController::class, 'GetSaleMonth'])->name('order.GetSaleMonth');
    Route::get('/orderview', [\App\Http\Controllers\OrderController::class, 'getview'])->name('order.view');
    Route::get('/order/getMonthOrder', '\App\Http\Controllers\OrderController@getMonthOrder')->name('order.month');
    Route::get('order/getbestsellers', '\App\Http\Controllers\OrderController@getbestsellers')->name('order.bestsellers');
    Route::get('order/selectMonth', '\App\Http\Controllers\OrderController@selectMonth')->name('order.selectMonth');
    Route::get('order/filterYearMonth', '\App\Http\Controllers\OrderController@filterYearMonth')->name('order.filterYearMonth');
    Route::get('/worker/asist/{user}', [worker::class, 'getAsistByWorker'])->name('Asist.ByWorker');
    Route::get('/order/getBestClient', [\App\Http\Controllers\OrderController::class, 'getBestClient'])->name('order.getBestClient');
    Route::get('/supply/dashboard', [SupplyController::class, 'dashboardSupply'])->name('supplyDashboard');
    Route::get('/supply/notification', [SupplyController::class, 'notificationSupply'])->name('supplyNotification');
    Route::get('/product/dashboard', [ProductController::class, 'dashboardProduct'])->name('productDashboard');
    Route::get('/publicity/sendCoupon', [SendCouponController::class, 'index'])->name('sendCoupon.index');


    // Route::get('/worker/asist/{user}',[worker::class,'getAsistByWorker'])->name('Asist.ByWorker');
    Route::get('/worker/asist/{user}', [worker::class, 'getAsistByWorker'])->name('Asist.ByWorker');
    Route::get('/order/pending', [OrderController::class, 'pendingOrdersView'])->name('pendingOrdersView');
    Route::get('/order/ready', [OrderController::class, 'readyOrdersView'])->name('readyOrdersView');
    Route::post('/order/updateOrder', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    //POST
    Route::post('/supply/excel', [\App\Http\Controllers\SupplyController::class, 'importExcel'])->name('supply.excel');
    Route::get('/supply/import/', [\App\Http\Controllers\SupplyController::class, 'importExcelView'])->name('supply.import');
    Route::post('/asist/finish/{asist}', [AsistController::class, 'finishAsist'])->name('finish.asist');
    Route::post('/order/addproduct', [\App\Http\Controllers\OrderController::class, 'addproduct'])->name('order.addproduct');
    Route::post('/order/selectproduct', [\App\Http\Controllers\OrderController::class, 'selectproduct'])->name('order.selectproduct');
    Route::post('/product/productModalEditStore/{product}', [ProductController::class, 'productModalEditStore'])->name('product.modal.edit.store');
    Route::post('/publicity/couponSend', [SendCouponController::class, 'store'])->name('sendCoupon.store');
    Route::post('/publicity/orderReady', [SendCouponController::class, 'orderReady'])->name('send.orderReady');

    //RESOURCE
    Route::resource('category_supply', CategorySupplyController::class);
    Route::resource('supply', SupplyController::class);
    Route::resource('worker', worker::class);
    Route::resource('asist', AsistController::class);
    Route::resource('order', OrderController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category_product', CategoryProductController::class);
    Route::resource('coupon', CouponController::class);
    Route::resource('map', MapController::class);
    Route::resource('publicity', ImageMainController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/landing/profile/', [LandingController::class, 'userProfile'])->name('user.profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/user/orderDetails', [\App\Http\Controllers\UserController::class, 'orderDetails'])->name('order.details');
Route::get('/user/orderbyuser', [\App\Http\Controllers\UserController::class, 'orderbyuser'])->name('order.history');
Route::get('/user/findOrder', [\App\Http\Controllers\UserController::class, 'findOrder'])->name('order.find');
Route::get('/user/showOrder', [\App\Http\Controllers\UserController::class, 'showOrder'])->name('show.order');
Route::get('/landing/cart/', [LandingController::class, 'userCart'])->name('user.cart');
Route::post('/landing/confirmation/', [LandingController::class, 'transactionConfirmation'])->name('landing.confirmation');
Route::get('/landing/voucher/', [\App\Http\Controllers\LandingController::class, 'transactionVoucher'])->name('landing.voucher');
Route::post('/delivery/price', [MapController::class, 'deliveryPrice'])->name('delivery.price');


//RUTAS PARA LA VISTA DE USUARIOS
Route::post('/login/check', [UserController::class, 'login'])->name('user.login');
//DEBEN ESTAR EN MIDDLEWARE
Route::patch('/landing/update/{user}', [LandingController::class, 'updateUserProfile'])->name('user.update.profile');
Route::get('/landing/check/coupon', [LandingController::class, 'checkCoupon'])->name('landing.check.coupon');

////////////////////////////////////////////////////////////////////////////////////////
Route::resource('user', UserController::class);
Route::resource('landing', LandingController::class);


// RUTAS DE ORDENES


//RUTAS PARA EL INICIO DE SESIÓN CON GOOGLE
Route::get('/login/google', [GoogleController::class, 'HandleGoogleLogin'])->name('login.google');
Route::get('/google/callback', [GoogleController::class, 'HandleGoogleCallback']);

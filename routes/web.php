<?php

<<<<<<< Updated upstream
=======
use App\Http\Controllers\CategorySupplyController;
use App\Http\Controllers\SupplyController;
>>>>>>> Stashed changes
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\UserController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\LandingController;
use App\Http\Controllers\worker;
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyRoles;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//RUTAS DE CUPONES
Route::get('/coupon/refresh/coupon', [\App\Http\Controllers\CouponController::class, 'refreshCoupons'])->name('coupon.refresh.coupon');


<<<<<<< Updated upstream
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class)->middleware([]);
Route::resource('product', ProductController::class);
Route::resource('order', OrderController::class);
Route::resource('category_product', CategoryProductController::class);
Route::resource('coupon', CouponController::class);
Route::resource('user', UserController::class);
Route::resource('map', MapController::class);

// RUTAS DE PRODUCTOS
Route::get('/productView', [\App\Http\Controllers\ProductController::class, 'productView'])->name('product.view');
Route::get('/productModalEdit', [\App\Http\Controllers\ProductController::class, 'productModalEdit'])->name('product.modal.edit');
// RUTAS DE CATEGORÍAS
Route::get('/categoryProduct/modal/edit', [\App\Http\Controllers\CategoryProductController::class, 'categoryProductModalEdit'])->name('category.product.modal.edit');

// RUTA DE ROLES
Route::get('/permitsofrole', [\App\Http\Controllers\RoleController::class, 'getPermits'])->name('permits.roles');
//DataTables
Route::get('/dataTableRole', [\App\Http\Controllers\RoleController::class, 'dataTable'])->name('dataTable.Roles');
=======
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
    Route::get('/order/orderview', [\App\Http\Controllers\OrderController::class, 'getview'])->name('order.view');
    //POST
    Route::post('/asist/finish/{asist}', [AsistController::class, 'finishAsist'])->name('finish.asist');
    Route::post('/order/addproduct', [\App\Http\Controllers\OrderController::class, 'addproduct'])->name('order.addproduct');
    Route::post('/order/selectproduct', [\App\Http\Controllers\OrderController::class, 'selectproduct'])->name('order.selectproduct');
    Route::post('/product/productModalEditStore/{product}', [ProductController::class, 'productModalEditStore'])->name('product.modal.edit.store');


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
    Route::resource('user', UserController::class);
    Route::resource('map', MapController::class);
});

//RUTAS PARA LA VISTA DE USUARIOS
Route::resource('landing', LandingController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// RUTAS DE ORDENES
// RUTA DE ROLES
>>>>>>> Stashed changes

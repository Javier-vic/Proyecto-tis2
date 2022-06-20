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
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ImageMainController;
use App\Http\Controllers\worker;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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
    Route::get('/order/orderview', [\App\Http\Controllers\OrderController::class, 'getview'])->name('order.view');
    Route::get('/worker/asist/{user}', [worker::class, 'getAsistByWorker'])->name('Asist.ByWorker');
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
    Route::resource('map', MapController::class);
    Route::resource('publicity', ImageMainController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/landing/profile/', [LandingController::class, 'userProfile'])->name('user.profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

//RUTAS PARA LA VISTA DE USUARIOS
Route::post('/login/check', [UserController::class, 'login'])->name('user.login');
//DEBEN ESTAR EN MIDDLEWARE
Route::patch('/landing/update/{user}', [LandingController::class, 'updateUserProfile'])->name('user.update.profile');
Route::get('/landing/check/coupon', [LandingController::class, 'checkCoupon'])->name('landing.check.coupon');

////////////////////////////////////////////////////////////////////////////////////////
Route::resource('user', UserController::class);
Route::resource('landing', LandingController::class);
Route::resource('cart', CartController::class);


// RUTAS DE ORDENES
Route::get('/orderview', [\App\Http\Controllers\OrderController::class, 'getview'])->name('order.view');
Route::get('/getMonthOrder', '\App\Http\Controllers\OrderController@getMonthOrder')->name('order.month');
Route::get('/getbestsellers', '\App\Http\Controllers\OrderController@getbestsellers')->name('order.bestsellers');

//RUTAS PARA EL INICIO DE SESIÓN CON GOOGLE
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('/google-callback', function () {

    $user = Socialite::driver('google')->user();
    $checkCorreo = User::where('email', $user->email)->first();
    if ($checkCorreo) {
        Auth::login($checkCorreo);
        return redirect()->action('App\Http\Controllers\LandingController@index');
    } else {
        $newUser = new user;
        $newUser->name = $user->name;
        $newUser->email = $user->email;
        // $newUser->password = '';
        $newUser->id_role = '2'; //ROL DE CLIENTE 
        $newUser->address = 'Sin dirección';
        $newUser->phone = '0';
        $newUser->save();
        Auth::login($newUser);
    }
    return redirect()->action('App\Http\Controllers\LandingController@index');

    // $user->token
});
//FIN RUTAS INICIO SESIÓN GOOGLE
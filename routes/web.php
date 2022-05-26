<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\AsistController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyRoles;
use GuzzleHttp\Middleware;

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

Route::middleware(['auth', 'verifyrole'])->group(function () {
    //GET
    Route::get('/product/productView', [ProductController::class, 'productView'])->name('product.view');
    Route::get('/product/productModalEdit', [ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/product/productView', [ProductController::class, 'productView'])->name('product.view');
    Route::get('/product/productModalEdit', [ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/category_product/store/category', [CategoryProductController::class, 'store_category_product'])->name('categoryProduct');
    Route::get('/category_product/modal/edit', [CategoryProductController::class, 'categoryProductModalEdit'])->name('category.product.modal.edit');
    Route::get('/roles/permitsofrole', [RoleController::class, 'getPermits'])->name('permits.roles');
    Route::get('/roles/dataTableRole', [RoleController::class, 'dataTable'])->name('dataTable.Roles');
    Route::get('/asist/dataTable',[AsistController::class,'dataTable'])->name('dataTable.asist');
    //POST
    Route::post('/product/productModalEditStore/{product}', [ProductController::class, 'productModalEditStore'])->name('product.modal.edit.store');
    
    //RESOURCE
    Route::resource('asist',AsistController::class);
    Route::resource('order', OrderController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category_product', CategoryProductController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// RUTAS DE PRODUCTOS
// RUTAS DE CATEGORÍAS


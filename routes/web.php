<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryProductController;
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
    Route::get('/roles/dataTableRole', [RoleController::class, 'dataTable'])->name('dataTable.Roles');
    Route::get('/roles/permitsofrole', [RoleController::class, 'getPermits'])->name('permits.roles')->middleware(['auth']);
    Route::get('/product/category_product/store/category', [CategoryProductController::class, 'store_category_product'])->name('categoryProduct');
    Route::get('/product/productView', [\App\Http\Controllers\ProductController::class, 'productView'])->name('product.view');
    Route::get('/product/productModalEdit', [\App\Http\Controllers\ProductController::class, 'productModalEdit'])->name('product.modal.edit');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    //POST
    Route::post('/product/productModalEditStore/{product}', [\App\Http\Controllers\ProductController::class, 'productModalEditStore'])->name('product.modal.edit.store');
    
    //RESOURCE
    Route::resource('order', OrderController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category_product', CategoryProductController::class);
});

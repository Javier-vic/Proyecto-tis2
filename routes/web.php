<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('roles', RoleController::class);
Route::resource('product', ProductController::class);
Route::resource('order', OrderController::class);
Route::resource('category_product', CategoryProductController::class);

// RUTAS DE PRODUCTOS
Route::get('/productView', [\App\Http\Controllers\ProductController::class, 'productView'])->name('product.view');
Route::get('/productModalEdit', [\App\Http\Controllers\ProductController::class, 'productModalEdit'])->name('product.modal.edit');
// RUTAS DE CATEGORÍAS
Route::get('/categoryProduct/modal/edit', [\App\Http\Controllers\CategoryProductController::class, 'categoryProductModalEdit'])->name('category.product.modal.edit');

// RUTA DE ROLES
Route::get('/permitsofrole', [\App\Http\Controllers\RoleController::class, 'getPermits'])->name('permits.roles');
//DataTables
Route::get('/dataTableRole', [\App\Http\Controllers\RoleController::class, 'dataTable'])->name('dataTable.Roles');

Route::post('/selectproduct', [\App\Http\Controllers\OrderController::class, 'selectproduct'])->name('order.selectproduct');
Route::post('/addproduct', [\App\Http\Controllers\OrderController::class, 'addproduct'])->name('order.addproduct');
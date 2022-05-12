<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
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
Route::resource('category_product', CategoryProductController::class);

Route::get('/category_product/store/category', [CategoryProductController::class, 'store_category_product'])->name('categoryProduct');

//DataTables
Route::get('/dataTableRole',[\App\Http\Controllers\RoleController::class,'dataTable'])->name('dataTable.Roles');
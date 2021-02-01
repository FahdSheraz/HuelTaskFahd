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

Route::get('/', 'HomeController@index');

//Products
Route::get('/products', 'HomeController@products')->name('products');
Route::get('/products/import', 'HomeController@productsImport');

//customers
Route::get('/customers', 'HomeController@customers')->name('customers');
Route::get('/customers/import', 'HomeController@customersImport');

//customers
Route::get('/orders', 'HomeController@orders')->name('orders');
Route::get('/orders/import', 'HomeController@ordersImport');
Route::get('/orders/{filter}/{id}', 'HomeController@filterOrders');
<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/save', 'HomeController@save')->name('home.save');

Route::prefix('customer')->group(function(){
    Route::get('/', 'CustomerController@index')->name('customer.index');
    Route::post('/', 'CustomerController@store')->name('customer.store');
    Route::get('/get/all', "CustomerController@getRow")->name('customer.get');
    Route::put('/{id}', 'CustomerController@update')->name('customer.update');
    Route::delete('/{id}', 'CustomerController@destroy')->name('customer.destroy');
});

Route::prefix('category')->group(function(){
    Route::get('/', 'CategoryController@index')->name('category.index');
    Route::post('/', 'CategoryController@store')->name('category.store');
    Route::get('/get/all', "CategoryController@getRow")->name('category.get');
    Route::put('/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('/{id}', 'CategoryController@destroy')->name('category.destroy');
});

Route::prefix('table')->group(function(){
    Route::get('/', 'TableController@index')->name('table.index');
    Route::post('/', 'TableController@store')->name('table.store');
    Route::get('/get/all', "TableController@getRow")->name('table.get');
    Route::put('/{id}', 'TableController@update')->name('table.update');
    Route::delete('/{id}', 'TableController@destroy')->name('table.destroy');
});


Route::prefix('product')->group(function(){
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::post('/', 'ProductController@store')->name('product.store');
    Route::get('/get/all', "ProductController@getRow")->name('product.get');
    Route::get('/select', "ProductController@rowsByCate")->name('product.select');
    Route::put('/{id}', 'ProductController@update')->name('product.update');
    Route::delete('/{id}', 'ProductController@destroy')->name('product.destroy');   
});

Route::prefix('product/rows')->group(function(){
    Route::get('/{cate}', 'ProductController@rowsByCate')->name('rowsByCate');
});

Route::get('/latest-products-json', 'HomeController@latest_product_json')->name('product_latest_product_json');
Route::get('/json/category/rows/', 'HomeController@category_json')->name('product_category_json');
Route::get('/json/search-product-json/{limit}/{key}',"HomeController@search_product_json");
Route::get('/json-customer-rows',"HomeController@json_customer_rows");
Route::get('/json-table-rows',"HomeController@table_json");

Route::prefix('view')->group(function(){
    Route::get('/', 'HomeController@index')->name('view.index');
    Route::get('/get/all', "HomeController@getRow")->name('view.get');
});

/* Route::get('/', function()
{
    $img = Image::make('foo.jpg')->resize(300, 200);

    return $img->response('jpg');
}); */

/* Route::prefix('customer')->group(function(){
    Route::resource('/', 'CustomerController');
    Route::get('/get/all', "CustomerController@getRow")->name('customer.get');
    Route::put('/{id}', 'CustomerController@update')->name('customer.update')
});
 */

//Route::get('/customer', 'CustomerController@index')->name('customer.index');
//Route::get('/customer', 'CustomerController@store')->name('customer.store');
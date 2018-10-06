<?php

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

Route::get('/home', 'HomeController@index')->name('home');

/* 
Install App 
Gets permission for read and write and access token for API calls
*/
Route::get('install-shop','ShopifyController@installShop');
Route::get('process-oauth-result','ShopifyController@getAccessToken');

/* Get All Products */
Route::get('get-products','ShopifyController@getProducts');
/* Rrefresh Table */
Route::get('reload-table','ShopifyController@reloadTable');
/* Filter Product */
Route::get('filter-products','ShopifyController@filterProduct');
/* Add Products */
Route::get('add-product','ShopifyController@addProduct');
/* Delete Product */
Route::get('delete-product', 'ShopifyController@deleteProduct');
/* Update Product */
Route::get('update-product', 'ShopifyController@updateProduct');



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

Route::get('/home', 'HomeController@index');
Route::resource('agencys', 'AgencyController');
Route::resource('items', 'ItemController');
Route::get('api/items/{search}','ItemController@search');
Route::get('importItems','HomeController@importBrand');


Route::resource('orders', 'OrderController');
Route::post('/order2ship','OrderController@order2ship');
Route::post('/order2pay','OrderController@order2pay');

Route::post('purchase_orders/newpurchase2','PurchaseOrderController@newOrder2');
Route::get('purchase_orders/review','PurchaseOrderController@purchaseReview');
Route::resource('purchase_orders', 'PurchaseOrderController');

Route::post('utility/images/upload','UtilityController@imageUpload');


/*Client parts*/
Route::get('wechat','ClientControlller@show');
Route::get('client/search','ClientControlller@search');
Route::post('wechat','ClientControlller@index');
Route::post('client/logout','ClientControlller@logout');
Route::get('api/client/items/{search}','ClientControlller@itemSearch');



<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

    ], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('/employee','Api\EmployeeController');
Route::apiResource('/supplier','Api\SupplierController');
Route::apiResource('/category','Api\CategoryController');
Route::apiResource('/product','Api\ProductController');
Route::post('/stock/update/{id}','Api\ProductController@updateStock');
Route::apiResource('/expense','Api\ExpenseController');
Route::apiResource('/customer','Api\CustomerController');

//salary manage
Route::post('/salary/paid/{id}','Api\SalaryController@paid');
Route::get('/salary','Api\SalaryController@allSalary');
Route::get('/salary/view/{id}','Api\SalaryController@viewSalary');
Route::get('/salary/edit/{id}','Api\SalaryController@editSalary');
Route::post('/salary/update/{id}','Api\SalaryController@updateSalary');

Route::get('/get_product/{id}','Api\PosController@get_product');
//cart routes
Route::get('/addToCart/{id}','Api\CartController@addToCart');
Route::get('/cart/products','Api\CartController@cartProducts');
Route::get('/removeItem/{id}','Api\CartController@removeProduct');
Route::get('/increament/{id}','Api\CartController@cartInceament');
Route::get('/decreament/{id}','Api\CartController@cartDecrement');
Route::get('/vats','Api\CartController@getVat');
//order routes
Route::post('/orderDone','Api\PosController@orderDone');
Route::get('/orders','Api\Ordercontroller@todayOrders');
Route::get('/order/details/{id}','Api\Ordercontroller@ordderDetails');
Route::get('/order/order_details/{id}','Api\Ordercontroller@ordderDetailsAll');
Route::post('/search/order','Api\Ordercontroller@searchOrderDate');

//home routes
Route::get('/today/sell','Api\PosController@todaysSell');
Route::get('/today/income','Api\PosController@todaysIncome');
Route::get('/today/due','Api\PosController@todaysDue');
Route::get('/today/expense','Api\PosController@todayExpense');
Route::get('/today/stockout','Api\PosController@stockout');


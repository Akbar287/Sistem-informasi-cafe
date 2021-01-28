<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'confirm' => false, 'reset' => false]);

Route::group(['middleware' => ['auth', 'cekStatus']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/outlet/maps', 'OutletController@maps')->name('home');

    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::put('/profile', 'UserController@update')->name('profile');

    Route::get('/report', 'ReportController@index')->name('Report');
    Route::get('/settings', 'SettingController@index')->name('Setting');
    Route::get('/devices', 'DeviceController@index')->name('Device');

    //Puchase Order
    Route::get('/purchase', 'PurchaseController@index')->name('Purchase');
    Route::get('/purchase/create', 'PurchaseController@create')->name('Purchase');

    //List Order
    Route::get('/purchase/list', 'PurchaseController@list')->name('Purchase List');


    //Promo // Belum Selesai
    Route::get('/promo', 'PromoController@index')->name('Promo');
    Route::get('/promo/code', 'PromoController@codeMaker')->name('Promo');
    Route::get('/promo/special', 'PromoController@create_special')->name('Promo');
    Route::get('/promo/voucher', 'PromoController@create_voucher')->name('Promo');
    Route::get('/promo/special/{id}', 'PromoController@show_special')->name('Promo');
    Route::get('/promo/voucher/{id}', 'PromoController@show_voucher')->name('Promo');
    Route::get('/promo/special/{id}/edit', 'PromoController@edit_special')->name('Promo');
    Route::get('/promo/voucher/{id}/edit', 'PromoController@edit_voucher')->name('Promo');
    Route::post('/promo/special', 'PromoController@store_special')->name('Promo');
    Route::post('/promo/voucher', 'PromoController@store_voucher')->name('Promo');
    Route::put('/promo/special/{id}', 'PromoController@update_special')->name('Promo');
    Route::put('/promo/voucher/{id}', 'PromoController@update_voucher')->name('Promo');
    Route::delete('/promo/special/{id}', 'PromoController@destroy_special')->name('Promo');
    Route::delete('/promo/voucher/{id}', 'PromoController@destroy_voucher')->name('Promo');

    //Customers
    Route::get('/customer', 'CustomerController@index')->name('Customer');
    Route::get('/customer/create', 'CustomerController@create')->name('Customer');
    Route::get('/customer/{id}', 'CustomerController@show')->name('Customer');
    Route::get('/customer/{id}/edit', 'CustomerController@edit')->name('Customer');
    Route::post('/customer', 'CustomerController@store')->name('Customer');
    Route::put('/customer/{id}', 'CustomerController@update')->name('Customer');
    Route::delete('/customer/{id}', 'CustomerController@destroy')->name('Customer');

    //Category
    Route::get('/category', 'CategoryController@index')->name('Category');
    Route::get('/category/create', 'CategoryController@create')->name('Category');
    Route::get('/category/{id}', 'CategoryController@show')->name('Category');
    Route::get('/category/{id}/edit', 'CategoryController@edit')->name('Category');
    Route::post('/category', 'CategoryController@store')->name('Category');
    Route::put('/category/{id}', 'CategoryController@update')->name('Category');
    Route::delete('/category/{id}', 'CategoryController@destroy')->name('Category');

    //Material
    Route::get('/material', 'MaterialController@index')->name('Material');
    Route::get('/material/create', 'MaterialController@create')->name('Material');
    Route::get('/material/{id}', 'MaterialController@show')->name('Material');
    Route::get('/material/{id}/edit', 'MaterialController@edit')->name('Material');
    Route::post('/material', 'MaterialController@store')->name('Material');
    Route::put('/material/{id}', 'MaterialController@update')->name('Material');
    Route::delete('/material/{id}', 'MaterialController@destroy')->name('Material');

    //Products
    Route::get('/product', 'ProductsController@index')->name('Product');
    Route::get('/product/create', 'ProductsController@create')->name('Product');
    Route::get('/product/{id}', 'ProductsController@show')->name('Product');
    Route::get('/product/{id}/edit', 'ProductsController@edit')->name('Product');
    Route::post('/product', 'ProductsController@store')->name('Product');
    Route::put('/product/{id}', 'ProductsController@update')->name('Product');
    Route::delete('/product/{id}', 'ProductsController@destroy')->name('Product');

    //Stock Cards
    Route::get('/stock/card', 'StockCardController@index')->name('StockCard');
    Route::get('/stock/card/create', 'StockCardController@create')->name('StockCard');
    Route::get('/stock/card/{id}', 'StockCardController@show')->name('StockCard');
    Route::get('/stock/card/{id}/edit', 'StockCardController@edit')->name('StockCard');
    Route::post('/stock/card', 'StockCardController@store')->name('StockCard');
    Route::put('/stock/card/{id}', 'StockCardController@update')->name('StockCard');
    Route::delete('/stock/card/{id}', 'StockCardController@destroy')->name('StockCard');

    //Stock In //Belum Selesai --put, delete
    Route::get('/stock/in', 'StockInController@index')->name('StockIn');
    Route::get('/stock/in/create', 'StockInController@create')->name('StockIn');
    Route::post('/stock/in/create', 'StockOpnameController@getProductData')->name('StockIn');
    Route::get('/stock/in/{id}', 'StockInController@show')->name('StockIn');
    Route::get('/stock/in/{id}/edit', 'StockInController@edit')->name('StockIn');
    Route::post('/stock/in', 'StockInController@store')->name('StockIn');
    Route::put('/stock/in/{id}', 'StockInController@update')->name('StockIn');
    Route::delete('/stock/in/{id}', 'StockInController@destroy')->name('StockIn');

    //Stock Opname //Belum Selesai --put, delete
    Route::get('/stock/opname', 'StockOpnameController@index')->name('StockOpname');
    Route::get('/stock/opname/create', 'StockOpnameController@create')->name('StockOpname');
    Route::post('/stock/opname/create', 'StockOpnameController@getProductData')->name('StockOpname');
    Route::get('/stock/opname/{id}', 'StockOpnameController@show')->name('StockOpname');
    Route::get('/stock/opname/{id}/edit', 'StockOpnameController@edit')->name('StockOpname');
    Route::post('/stock/opname', 'StockOpnameController@store')->name('StockOpname');
    Route::put('/stock/opname/{id}', 'StockOpnameController@update')->name('StockOpname');
    Route::delete('/stock/opname/{id}', 'StockOpnameController@destroy')->name('StockOpname');

    //Stock Transfer //Belum Selesai --put,delete
    Route::get('/stock/transfer', 'StockTransferController@index')->name('StockTransfer');
    Route::get('/stock/transfer/create', 'StockTransferController@create')->name('StockTransfer');
    Route::post('/stock/transfer/getCustomData', 'StockTransferController@getCustomData')->name('StockTransfer');
    Route::post('/stock/transfer/create', 'StockTransferController@getProductData')->name('StockTransfer');
    Route::get('/stock/transfer/{id}', 'StockTransferController@show')->name('StockTransfer');
    Route::get('/stock/transfer/{id}/edit', 'StockTransferController@edit')->name('StockTransfer');
    Route::post('/stock/transfer', 'StockTransferController@store')->name('StockTransfer');
    Route::put('/stock/transfer/{id}', 'StockTransferController@update')->name('StockTransfer');
    Route::delete('/stock/transfer/{id}', 'StockTransferController@destroy')->name('StockTransfer');

    //Stock Out // Belum Selesai ,store,put,delete
    Route::get('/stock/out', 'StockOutController@index')->name('StockOut');
    Route::get('/stock/out/create', 'StockOutController@create')->name('StockOut');
    Route::post('/stock/out/create', 'StockOpnameController@getProductData')->name('StockOut');
    Route::get('/stock/out/{id}', 'StockOutController@show')->name('StockOut');
    Route::get('/stock/out/{id}/edit', 'StockOutController@edit')->name('StockOut');
    Route::post('/stock/out', 'StockOutController@store')->name('StockOut');
    Route::put('/stock/out/{id}', 'StockOutController@update')->name('StockOut');
    Route::delete('/stock/out/{id}', 'StockOutController@destroy')->name('StockOut');

    Route::get('/product/{id}/varian', 'ProductsController@variantCreate')->name('Product');
    Route::get('/product/{id}/varian/{var}', 'ProductsController@variantShow')->name('Product');
    Route::get('/product/{id}/varian/{var}/edit', 'ProductsController@variantEdit')->name('Product');
    Route::post('/product/{id}/varian', 'ProductsController@variantStore')->name('Product');
    Route::put('/product/{id}/varian/{var}', 'ProductsController@variantUpdate')->name('Product');
    Route::delete('/product/{id}/varian/{var}', 'ProductsController@variantDestroy')->name('Product');

    //Employees
    Route::get('/employees', 'EmployeesController@index')->name('Employees');
    Route::get('/employee/create', 'EmployeesController@create')->name('Employees');
    Route::get('/employee/{id}', 'EmployeesController@show')->name('Employees');
    Route::get('/employee/{id}/edit', 'EmployeesController@edit')->name('Employees');
    Route::post('/employee', 'EmployeesController@store')->name('Employees');
    Route::put('/employee/{id}', 'EmployeesController@update')->name('Employees');
    Route::delete('/employee/{id}', 'EmployeesController@destroy')->name('Employees');

    //supplier
    Route::get('/supplier', 'SupplierController@index')->name('Supplier');
    Route::get('/supplier/create', 'SupplierController@create')->name('Supplier');
    Route::get('/supplier/{id}', 'SupplierController@show')->name('Supplier');
    Route::get('/supplier/{id}/edit', 'SupplierController@edit')->name('Supplier');
    Route::get('/supplier/{id}/outlet', 'SupplierController@outlet')->name('Supplier');
    Route::post('/supplier', 'SupplierController@store')->name('Supplier');
    Route::put('/supplier/{id}', 'SupplierController@update')->name('Supplier');
    Route::delete('/supplier/{id}', 'SupplierController@destroy')->name('Supplier');

    //Outlet
    Route::get('/outlet', 'OutletController@index')->name('Outlet');
    Route::get('/outlet/create', 'OutletController@create')->name('Outlet');
    Route::get('/outlet/{id}', 'OutletController@show')->name('Outlet');
    Route::get('/outlet/{id}/edit', 'OutletController@edit')->name('Outlet');
    Route::post('/outlet', 'OutletController@store')->name('Outlet');
    Route::put('/outlet/{id}', 'OutletController@update')->name('Outlet');
    Route::delete('/outlet/{id}', 'OutletController@destroy')->name('Outlet');

    //Pajak & Services
    Route::get('/tax', 'TaxController@index')->name('Tax');
    Route::get('/tax/create', 'TaxController@create')->name('Tax');
    Route::get('/tax/{id}', 'TaxController@show')->name('Tax');
    Route::get('/tax/{id}/edit', 'TaxController@edit')->name('Tax');
    Route::post('/tax', 'TaxController@store')->name('Tax');
    Route::put('/tax/{id}', 'TaxController@update')->name('Tax');
    Route::delete('/tax/{id}', 'TaxController@destroy')->name('Tax');
});

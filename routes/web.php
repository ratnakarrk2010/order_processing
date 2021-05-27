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


use App\Http\Controllers\GoogleSpreadSheetController;
use App\Http\Controllers\OrderDataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoleMasterController;
use App\Http\Controllers\PaymentTermsController;
use App\Http\Controllers\MenuMasterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TaxMasterController;

Route::post('/order', [GoogleSpreadSheetController::class, 'submitOrder']);
Route::get('/order', [OrderDataController::class, 'showOrderForm']);
Route::get('/test', [GoogleSpreadSheetController::class, 'testCreateCell']);

Route::get('/', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'makeLogin']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/login/{val}',  [LoginController::class, 'sessionExpired']);
 
Route::group(['middleware' => 'osession'], function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    //Roles Route
    Route::get('/role/list', [RoleMasterController::class, 'index']);
    Route::post('/save/role', [RoleMasterController::class, 'saveRole']);
    Route::get('/role/delete/{roleId}', [RoleMasterController::class, 'deleteRole']);
    Route::post('/update/role', [RoleMasterController::class, 'updateRoleDetails']);
    
    //Payment Terms Route
    Route::get('/paymentterms/list', [PaymentTermsController::class, 'index']);
    Route::post('/save/payment/terms', [PaymentTermsController::class, 'savePaymentTerms']);
    Route::get('/payment/terms/delete/{roleId}', [PaymentTermsController::class, 'deletePaymentTerms']);
    Route::post('/update/payment/terms', [PaymentTermsController::class, 'updatePaymentTermsDetails']);
     
	//Tax Route
	Route::get('/tax/list', [TaxMasterController::class, 'index']);
	Route::post('/save/tax', [TaxMasterController::class, 'saveTax']);
	Route::get('/tax/delete/{taxId}', [TaxMasterController::class, 'deleteTax']);
	Route::post('/update/tax', [TaxMasterController::class, 'updateTaxDetails']);

    //Menu Routes
    Route::get('/menu/list', [MenuMasterController::class, 'index']);
    Route::get('/rolemenu/map/list', [MenuMasterController::class, 'menuMappingList']);
    Route::post('/save/rolemenu/map', [MenuMasterController::class, 'saveRoleMenuMap']);
    Route::post('/update/role/menumap', [MenuMasterController::class, 'updateRoleMenuMap']);
    Route::get('/rolemenu/delete/{roleMapId}', [MenuMasterController::class, 'deleteRoleMap']);
    
    //Users Route
    Route::get('/add/user', [UsersController::class, 'index']);
    Route::post('/save/user', [UsersController::class, 'createUser']);
    Route::get('/all/user', [UsersController::class, 'list']);
    Route::get('/users/edit/{userId}', [UsersController::class, 'edit']);
    Route::post('/users/update', [UsersController::class, 'update']);
    Route::get('/users/delete/{userId}', [UsersController::class, 'deleteUser']);
    Route::get('/export_excel/excel', [UsersController::class, 'excel'])->name('export_excel.excel');;
    Route::get('/users/profile', [UsersController::class, 'getUserRecordForUpdate']);
    Route::post('/change/password', [UsersController::class, 'changeUserPassword']);
    Route::post('/update/profile', [UsersController::class, 'updateLoggedInUserProfile']);
    
   // Route::post('/email_available/checkEmail', 'UsersController@checkEmail')->name('email_available.checkEmail');


    //Customer Routes
    Route::get('/add/customer', [CustomerController::class, 'index']);
    Route::post('/save/customer', [CustomerController::class, 'createCustomer']);
    Route::get('/all/customer', [CustomerController::class, 'list']);
    Route::get('/customer/edit/{userId}', [CustomerController::class, 'edit']);
    Route::post('/customer/update', [CustomerController::class, 'update']);
    Route::get('/customer/delete/{userId}', [CustomerController::class, 'deleteCustomer']);
    Route::get('/customer_export/excel', [CustomerController::class, 'exportCustomerData'])->name('customer_export.excel');

    

    //Orders Routes
    Route::get('/add/order', [OrderDataController::class, 'index']);
    Route::post('/save/order', [OrderDataController::class, 'createOrder']);
    Route::get('/all/orders', [OrderDataController::class, 'list']);
    Route::get('/order/edit/{orderId}', [OrderDataController::class, 'edit']);
    Route::post('/order/update', [OrderDataController::class, 'update']);

    Route::get('/order/details/{orderId}', [OrderDataController::class, 'details']);
    Route::get('/order/delete/{orderId}', [OrderDataController::class, 'deleteOrder']);

    Route::get('/add/installation', [OrderDataController::class, 'showInstallation']);
    Route::get('/add/paymentdetails', [OrderDataController::class, 'showPaymentDetails']);
    Route::post('/installation/update', [OrderDataController::class, 'updateInstallationDetails']);
    Route::post('/submit/paymentdetails', [OrderDataController::class, 'submitPaymentDetails']);
    Route::get('/order_export/excel', [OrderDataController::class, 'exportOrderData'])->name('order_export.excel');
    Route::get('/download/pdf/{orderId}',[OrderDataController::class,'generateOrderFormPDF']);
    Route::post('/update/paymentdetails', [OrderDataController::class, 'updatePaymentDetails']);

    Route::get('/menu/mapping', [MenuController::class, 'showMenuMappingPage']);
    Route::post('/search/menu/mapping', [MenuController::class, 'getMenuMappingForRole']);
    Route::post('/map/menu', [MenuController::class, 'updateMenuMapping']);
    Route::post('/installation/assigned', [OrderDataController::class, 'saveInstallationPerson']);
});

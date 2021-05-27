<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\GoogleSpreadSheetController;
use App\Http\Controllers\OrderDataController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MenuMasterController;
use App\Http\Controllers\RoleMasterController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/order', [GoogleSpreadSheetController::class, 'submitOrder']);

Route::get('/order/payment/details/{orderId}', [OrderDataController::class, 'getOrderPaymentDetails']);
Route::post('/email_available/check', [UsersController::class, 'checkEmail']);
Route::delete('/installation/address/{installationAddressId}', [OrderDataController::class, 'removeInstallationAddress']);
Route::delete('/order/details/{orderDetailsId}', [OrderDataController::class, 'removeOrderDetails']);
Route::get('/submenu/all/{parentMenuID}', [MenuMasterController::class, 'getAllSubMenu']);
Route::post('validate/invoiceno', [OrderDataController::class, 'validateInvoiceNo']);
Route::get('/order/installation/details/{orderId}', [OrderDataController::class, 'fetchInstallationAssignedTo']);
Route::get('/users/byrole/{roldId}', [RoleMasterController::class, 'getRoleWiseUsers']);
Route::get('/user/dashboard/{roleId}/{userId}', [DashboardController::class, 'getDashboardCountForUser']);

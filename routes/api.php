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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('signup', 'AuthController@signup');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'admin-auth'

], function ($router) {

    Route::post('login', 'AdminAuthController@login');
    Route::post('logout', 'AdminAuthController@logout');
    Route::post('signup', 'AdminAuthController@signup');
    Route::post('refresh', 'AdminAuthController@refresh');
    Route::post('me', 'AdminAuthController@me');
    Route::get('menu', 'AdminAuthController@menu');
});

Route::apiResource('item', 'ItemController');
Route::apiResource('itemexp', 'ItemExpController');
Route::apiResource('room', 'RoomController');
Route::apiResource('booking', 'BookingOrderController');
Route::apiResource('cashbank', 'CashbankOrderController');
Route::apiResource('account', 'AccountController');
Route::apiResource('roomgroup', 'RoomGroupController');
Route::apiResource('sales', 'SalesOrderController');
Route::apiResource('service', 'ServiceController');
Route::apiResource('serviceorder', 'ServiceOrderController');
Route::apiResource('journal', 'JournalOrderController');
Route::apiResource('admin', 'AdminAuthController');
Route::apiResource('groupcode', 'GroupcodeController');
Route::apiResource('area', 'AreaController');
Route::apiResource('narration', 'NarrationController');
Route::apiResource('purchaseorder', 'PurchaseOrderController');

Route::get('permission/{permissionName}', 'PermissionController@check');
Route::get('permission/get/{admin}', 'PermissionController@getPermission');
Route::patch('permission/refresh/{admin}', 'PermissionController@refreshPermission');

Route::get('booking/search/{room_group_id}/{from_date}/{to_date}/{num_of_room}/{booking_id?}', 'BookingOrderController@search');
Route::post('booking/adminstore', 'BookingOrderController@adminStore');
Route::get('booking/roominfo/{booking}', 'BookingOrderController@getRoomInfo');
Route::get('booking/confirm/{booking}', 'BookingOrderController@confirm');
Route::get('booking/get/avalroom', 'BookingOrderController@avalRoom');
Route::get('booking/get/checkin', 'BookingOrderController@getCheckin');
Route::get('booking/get/checkout', 'BookingOrderController@getCheckout');
Route::get('booking/get/invoice', 'BookingOrderController@getInvoice');
Route::post('booking/store/checkin', 'BookingOrderController@storeCheckin');
Route::post('booking/store/checkout', 'BookingOrderController@storeCheckout');
Route::get('booking/print/invoice/{booking}', 'BookingOrderController@printInvoice');
Route::get('cashbank/print/receipt/{cashbank}', 'CashbankOrderController@printReceipt');
Route::get('sales/print/invoice/{sale}', 'SalesOrderController@printInvoice');
Route::get('serviceorder/print/invoice/{serviceorder}', 'ServiceOrderController@printInvoice');

Route::get('itemgroup', 'ItemGroupController@index');

Route::get('account/get/{payment_type_id}/{account_type_id?}/{account_id?}/{groupcode_id?}', 'AccountController@getAccount');

Route::get('cashbank/report/{date_from?}/{date_to?}/{acct_id?}', 'CashbankOrderController@getReport');
Route::get('cashbank/print/report/{date_from?}/{date_to?}/{acct_id?}', 'CashbankOrderController@printReport');

Route::get('journal/report/{date_from?}/{date_to?}/{acct_id?}', 'JournalOrderController@getReport');
Route::get('journal/print/report/{date_from?}/{date_to?}/{acct_id?}', 'JournalOrderController@printReport');

Route::get('ledger/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@getReport');
Route::get('ledger/print/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@printReport');
Route::get('acctbal/print/report/{acct}/{date_to?}', 'LedgerController@printAcctBal');
Route::get('ledger/get/acct/{acct_type_id?}/{group?}/{acct_id?}', 'LedgerController@getAcct');



Route::get('acctbal/{acct_id}/{date_from?}/{date_to?}', 'LedgerController@getBalance');
Route::post('send/enquiry', 'MainController@sendEnquiry');
Route::get('terms-and-conditions', 'MainController@terms');
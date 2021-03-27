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
Route::apiResource('cashbank', 'CashbankOrderController');
Route::apiResource('account', 'AccountController');
Route::apiResource('salesorder', 'SalesOrderController');
Route::apiResource('journal', 'JournalOrderController');
Route::apiResource('admin', 'AdminAuthController');
Route::apiResource('groupcode', 'GroupcodeController');
Route::apiResource('area', 'AreaController');
Route::apiResource('narration', 'NarrationController');
Route::apiResource('purchaseorder', 'PurchaseOrderController');


Route::get('permission/{permissionName}', 'PermissionController@check');
Route::get('permission/get/{admin}', 'PermissionController@getPermission');
Route::patch('permission/refresh/{admin}', 'PermissionController@refreshPermission');


Route::get('cashbank/print/receipt/{cashbank}', 'CashbankOrderController@printReceipt');
Route::get('sales/print/invoice/{sale}', 'SalesOrderController@printInvoice');

Route::get('account/get/{payment_type_id}/{account_type_id?}/{account_id?}/{groupcode_id?}', 'AccountController@getAccount');
Route::get('get/itemexp/{date_to}', 'ItemExpController@getItemExp');

Route::get('cashbank/report/{date_from?}/{date_to?}/{acct_id?}', 'CashbankOrderController@getReport');
Route::get('cashbank/print/report/{date_from?}/{date_to?}/{acct_id?}', 'CashbankOrderController@printReport');

Route::get('journal/report/{date_from?}/{date_to?}/{acct_id?}', 'JournalOrderController@getReport');
Route::get('journal/print/report/{date_from?}/{date_to?}/{acct_id?}', 'JournalOrderController@printReport');

Route::get('ledger/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@getReport');
Route::get('ledger/print/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@printReport');
Route::get('acctbal/print/report/{acct}/{date_to?}', 'LedgerController@printAcctBal');
Route::get('ledger/get/acct/{acct_type_id?}/{group?}/{acct_id?}', 'LedgerController@getAcct');



Route::get('acctbal/{acct_id}/{date_from?}/{date_to?}', 'LedgerController@getBalance');

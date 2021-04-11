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
Route::apiResource('company', 'CompanyController');
Route::apiResource('finyear', 'FinancialYearController');


Route::post('company/upload/{company}/{type}', 'CompanyController@upload');



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

Route::get('purchase/report/{date_from?}/{date_to?}/{acct_id?}', 'PurchaseOrderController@getReport');
Route::get('purchase/print/report/{date_from?}/{date_to?}/{acct_id?}', 'PurchaseOrderController@printReport');

Route::get('sales/report/{date_from?}/{date_to?}/{acct_id?}', 'SalesOrderController@getReport');
Route::get('sales/print/report/{date_from?}/{date_to?}/{acct_id?}', 'SalesOrderController@printReport');

Route::get('ledger/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@getReport');
Route::get('ledger/print/report/{date_from?}/{date_to?}/{acct_id?}', 'LedgerController@printReport');
Route::get('acctbal/print/report/{acct}/{date_to?}', 'LedgerController@printAcctBal');

Route::get('report/get/stock/{date_to?}/{item_id?}', 'ReportController@getStockReport');
Route::get('report/print/stock/{date_to?}/{item_id?}', 'ReportController@printStockReport');
Route::get('report/get/cashbankbalance', 'ReportController@getCashBankBalance');
Route::get('report/get/payable', 'ReportController@getPayable');
Route::get('report/get/receivable', 'ReportController@getReceivable');
Route::get('report/get/trialbal/{date_from}/{date_to}/{groupcode_id?}', 'ReportController@getTrialbal');
Route::get('report/print/trialbal/{date_from}/{date_to}/{groupcode_id?}', 'ReportController@printTrialbal');
Route::get('report/get/balsheet/{date_to}', 'ReportController@getBalsheet');
Route::get('report/print/balsheet/{date_to}', 'ReportController@printBalsheet');
Route::get('report/get/ploss/{date_from}/{date_to}', 'ReportController@getPloss');
Route::get('report/print/ploss/{date_from}/{date_to}', 'ReportController@printPloss');


Route::get('acctbal/{acct_id}/{date_from?}/{date_to?}', 'LedgerController@getBalance');

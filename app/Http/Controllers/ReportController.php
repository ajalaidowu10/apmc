<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DateTime;

class ReportController extends Controller
{
    function __construct()
    {
      $this->middleware('JWT');
    } 

    public function getStock(string $date_to, int $item_id = 0)
    {
      $company_id = Auth::guard('admin')->user()->company_id;
      $query = "SELECT t.id, t.name item_name, (SELECT IFNULL(sum(s.qty), 0) FROM sales_order_items AS s LEFT JOIN sales_orders sa ON sa.id = s.sales_order_id WHERE s.item_id = t.id AND s.del_record = 0 AND sa.company_id = ${company_id} AND sa.enter_date <= '${date_to}' ) outward_qty, (SELECT IFNULL(sum(p.qty), 0) FROM purchase_order_items AS p LEFT JOIN purchase_orders pa ON pa.id = p.purchase_order_id WHERE p.item_id = t.id AND p.del_record = 0 AND pa.company_id = ${company_id} AND pa.enter_date <= '${date_to}')  inward_qty FROM items t WHERE t.company_id = ${company_id} ";

      if ($item_id != 0) 
      {
          $query = "SELECT t.id, t.name item_name, (SELECT IFNULL(sum(s.qty), 0) FROM sales_order_items AS s LEFT JOIN sales_orders sa ON sa.id = s.sales_order_id WHERE s.item_id = t.id AND s.del_record = 0 AND sa.company_id = ${company_id} AND sa.enter_date <= '${date_to}' ) outward_qty, (SELECT IFNULL(sum(p.qty), 0) FROM purchase_order_items AS p LEFT JOIN purchase_orders pa ON pa.id = p.purchase_order_id WHERE p.item_id = t.id AND p.del_record = 0 AND pa.company_id = ${company_id} AND pa.enter_date <= '${date_to}')  inward_qty FROM items t WHERE t.company_id = ${company_id} AND t.id = ${item_id}";
      }

      $get_report = DB::select($query);
      
      return $get_report;
    }

    public function printStock(string $date_to, int $item_id = 0)
    {
      $get_report = $this->getStock($date_to, $item_id);

      $item_name = "";
      $date_to = new DateTime($date_to);

      if ($item_id != 0) 
      {
       $get_item = \App\Item::find($item_id);
       $item_name = $get_item->name;
      }

      return view('print.stock_report', [
                                              'get_report'    => $get_report,
                                              'date_to'       => $date_to,
                                              'item_id'       => $item_id,
                                              'item_name'     => $item_name,
                                           ]);
    }

    public function getCashBankBalance()
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->select(
                          DB::raw(
                                  'IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) - IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) balance, a.name acct_name, a.name acct_name'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->whereIn('a.account_type_id', [4,5])
                        ->groupBy('o.acct_one_id');

                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function getPayable()
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->select(
                          DB::raw(
                                  'IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) - IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) balance, a.name acct_name, a.name acct_name'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->where('a.groupcode_id', 19)
                        ->groupBy('o.acct_one_id');

                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function getReceivable()
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->select(
                          DB::raw(
                                  'IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) - IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) balance, a.name acct_name, a.name acct_name'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->where('a.groupcode_id', 10)
                        ->groupBy('o.acct_one_id');

                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function getTrialbal(string $date_from, string $date_to)
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->leftJoin('groupcodes as g', 'g.id', '=', 'a.groupcode_id')
                        ->select(
                          DB::raw(
                                  'IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) credit, IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) debit,  a.name acct_name, a.groupcode_id groupcode_id, g.name groupcode_name'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->groupBy('o.acct_one_id')
                        ->orderBy('g.name')
                        ->orderBy('a.name');

                        if ($date_from != '') 
                        {
                            $get_report = $get_report->where('o.enter_date', '>=', $date_from);
                        } 

                        if ($date_to != '') 
                        {
                            $get_report = $get_report->where('o.enter_date', '<=', $date_to);
                        }

                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }


}
     
       

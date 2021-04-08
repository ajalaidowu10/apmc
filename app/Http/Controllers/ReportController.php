<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DateTime;
use App\FinancialYear;

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

    public function printTrialbal(string $date_from, string $date_to)
    {
      $get_report = $this->getTrialbal($date_from, $date_to);

      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      return view('print.trialbal_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                           ]);
    }

    public function getBalsheetBy(string $date_to, int $parent_group_id = 0, int $not_parent_group_id = 0)
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->leftJoin('groupcodes as g', 'g.id', '=', 'a.groupcode_id')
                        ->leftJoin('parent_groupcodes as p', 'p.id', '=', 'g.parent_groupcode_id')
                        ->select(
                          DB::raw(
                                  'IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) - IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) result1, IFNULL(SUM(IF(o.crdr_id = 2, o.amount, 0)), 0) - IFNULL(SUM(IF(o.crdr_id = 1, o.amount, 0)), 0) result,  a.name acct_name, a.groupcode_id groupcode_id, g.name groupcode_name, g.parent_groupcode_id parent_groupcode_id3'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->groupBy('o.acct_one_id')
                        ->orderBy('g.name')
                        ->orderBy('a.name');

                        if ($parent_group_id != 0) 
                        {
                            $get_report = $get_report->where('g.parent_groupcode_id', $parent_group_id);
                        }

                        if ($not_parent_group_id != 0) 
                        {
                            $get_report = $get_report->where('g.parent_groupcode_id', '!=', $not_parent_group_id);
                        }

                        if ($date_to != '') 
                        {
                            $get_report = $get_report->where('o.enter_date', '<=', $date_to);
                        }


                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function profit_loss(string $date_to):float
    {
      $result = 0;
      $first_finyear = FinancialYear::where('company_id', Auth::guard('admin')->user()->company_id)->first();
      $year =  date('Y-m-d', strtotime('-1 day', strtotime($first_finyear->from_date)));
      if ($year == $date_to) 
      {
          return $result;
      } 

      $profit_loss = $this->getBalsheetBy($date_to, 2, 0);

      foreach ($profit_loss as $key) 
      {
        $result = $result + $key->result;
      }

      return number_format((float)$result, 2, '.', '');

    }

    public function getBalsheet(string $date_to)
    {
      $finyear_from = Auth::guard('admin')->user()->finyear->from_date;
      $asset_liability     = $this->getBalsheetBy($date_to, 0, 2);
      $prev_profit_loss    = $this->profit_loss($finyear_from);
      $profit_loss         = $this->profit_loss($date_to) - $prev_profit_loss;

      return ['asset_liability' => $asset_liability, 'prev_profit_loss' => $prev_profit_loss, 'profit_loss' => $profit_loss];

    }


}
     
       

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DateTime;
use App\FinancialYear;
use App\Account;

class ReportController extends Controller
{
    function __construct()
    {
      $this->middleware('JWT');
    } 

    public function getStockReport(string $date_to, int $item_id = 0)
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


    public function getStockValue(string $date_to)
    {
      $company_id = Auth::guard('admin')->user()->company_id;
      
      $query = "SELECT SUM(purchase_amount) - SUM(sales_amount) amount FROM ( SELECT t.id, t.name item_name, (SELECT IFNULL(sum(s.amount), 0) FROM sales_order_items AS s LEFT JOIN sales_orders sa ON sa.id = s.sales_order_id WHERE s.item_id = t.id AND s.del_record = 0 AND sa.company_id = ${company_id} AND sa.enter_date <= '${date_to}' ) sales_amount, (SELECT IFNULL(sum(p.final_amount), 0) FROM purchase_order_items AS p LEFT JOIN purchase_orders pa ON pa.id = p.purchase_order_id WHERE p.item_id = t.id AND p.del_record = 0 AND pa.company_id = ${company_id} AND pa.enter_date <= '${date_to}')  purchase_amount FROM items t WHERE t.company_id = ${company_id}) stocks";

      $get_report = DB::select($query);
      
      return $get_report;
    }

    public function printStockReport(string $date_to, int $item_id = 0)
    {
      $get_report = $this->getStockReport($date_to, $item_id);

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

    public function getTrialbal(string $date_from, string $date_to, int $groupcode_id = 0)
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

                        if ($groupcode_id != 0) 
                        {
                            $get_report = $get_report->where('g.id', $groupcode_id);
                        }

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

    public function printTrialbal(string $date_from, string $date_to, int $groupcode_id = 0)
    {
      $get_report = $this->getTrialbal($date_from, $date_to,$groupcode_id);

      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      $groupcode_name = "";

      if ($groupcode_id != 0) 
      {
       $get_groupcode = \App\Groupcode::find($groupcode_id);
       $groupcode_name = $get_groupcode->name;
      }

      return view('print.trialbal_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'groupcode_id'       => $groupcode_id,
                                              'groupcode_name'     => $groupcode_name,
                                           ]);
    }

    public function getLedgerWhere(string $date_to, int $parent_group_id = 0, int $not_parent_group_id = 0, int $sale_purchase_id = 0, int $transactype_id = 0)
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

                        if ($transactype_id != 0) 
                        {
                            $get_report = $get_report->where('o.transactype_id', $transactype_id);
                        }

                        if ($sale_purchase_id != 0) 
                        {
                            $sale_acct = Account::where('name', 'Sales Account')
                                                 ->where('company_id', Auth::guard('admin')->user()->company_id)
                                                 ->first();

                            $purchase_acct = Account::where('name', 'Purchase Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

                            $get_report = $get_report->whereIn('o.acct_one_id', [$sale_acct->id, $purchase_acct->id]);
                        }

                        if ($date_to != '') 
                        {
                            $get_report = $get_report->where('o.enter_date', '<=', $date_to);
                        }


                          
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    

    public function getProfitLoss(string $date_to):float
    {
      $result = 0;

      $first_finyear = FinancialYear::where('company_id', Auth::guard('admin')->user()->company_id)->first();
      $year =  date('Y-m-d', strtotime('-1 day', strtotime($first_finyear->from_date)));
      if ($year == $date_to) 
      {
          return $result;
      } 

      $profit_loss = $this->profit_loss($date_to);

      
      $stock_value = $this->stock_value($date_to);

      
      $result = $profit_loss * -1 + $stock_value;



      return number_format((float)$result, 2, '.', '');

    }

    public function profit_loss(string $date_to):float
    {
      $result = 0;

      $profit_loss = $this->getLedgerWhere($date_to, 2, 0, 0,0);

      foreach ($profit_loss as $key) 
      {
        $result = $result + $key->result;
      }

      return number_format((float)$result, 2, '.', '');

    }

    public function stock_value(string $date_to):float
    {
      $result = 0;

      $stock_value = $this->getLedgerWhere($date_to, 0, 0, 1,0);

      foreach ($stock_value as $key) 
      {
        $result = $result + $key->result;
      }

      if ($result < 0) 
      {
        return 0;
      }
      
      return number_format((float)$result, 2, '.', '');
    }

    public function open_bal(string $date_to):float
    {
      $result = 0;

      $open_bal = $this->getLedgerWhere($date_to, 0, 0, 0,1);

      foreach ($open_bal as $key) 
      {
        $result = $result + $key->result;
      }

            
      return number_format((float)$result, 2, '.', '');
    }





    public function getBalsheet(string $date_to)
    {
      $finyear_from = Auth::guard('admin')->user()->finyear->from_date;
      $asset_liability    = $this->getLedgerWhere($date_to, 0, 2, 0,0);
      $stock_value        = $this->stock_value($date_to);
      $prev_profit_loss   = $this->getProfitLoss($finyear_from);
      $profit_loss        = $this->getProfitLoss($date_to) - $prev_profit_loss;
      $openbal_diff       = $this->open_bal($date_to);

      $asset = [];
      $liability = [];

      foreach ($asset_liability as $value) 
      {
        if($value->result > 0)
        {
          array_push($asset, [
                              'groupcode_id' => $value->groupcode_id, 
                              'groupcode_name' => $value->groupcode_name,
                              'acct_name' => $value->acct_name,
                              'amount' => number_format((float)$value->result, 2, '.', '') 
                            ]);
        }
        else
        {
          array_push($liability, [
                                  'groupcode_id' => $value->groupcode_id, 
                                  'groupcode_name' => $value->groupcode_name,
                                  'acct_name' => $value->acct_name,
                                  'amount' => number_format((float)$value->result1, 2, '.', '') 
                                ]);
        }
      }

      array_push($liability, [
                            'groupcode_id' => 0, 
                            'groupcode_name' => 'Profit & Loss',
                            'acct_name' => 'Opening Balance',
                            'amount' => number_format((float)$prev_profit_loss, 2, '.', ''),
                        ]);
      array_push($liability, [
                            'groupcode_id' => 0, 
                            'groupcode_name' => 'Profit & Loss',
                            'acct_name' => 'Current Period',
                            'amount' => number_format((float)$profit_loss, 2, '.', ''),
                        ]);

      array_push($asset, [
                            'groupcode_id' => 0, 
                            'groupcode_name' => 'Stock Value',
                            'acct_name' => 'Stock Value',
                            'amount' => number_format((float)$stock_value, 2, '.', ''),
                        ]);


      if ($openbal_diff > 0) 
      {
        
        array_push($liability, [
                              'groupcode_id' => -1, 
                              'groupcode_name' => 'Diff. in Opening Balances',
                              'acct_name' => 'Diff. in Opening Balances',
                              'amount' => number_format((float)$openbal_diff, 2, '.', ''),
                          ]);
      } 
      else 
      {
        array_push($asset, [
                              'groupcode_id' => -1, 
                              'groupcode_name' => 'Diff. in Opening Balances',
                              'acct_name' => 'Diff. in Opening Balances',
                              'amount' => number_format((float)$openbal_diff * -1, 2, '.', ''),
                          ]);
      }
      

      return [
                'asset'       => $asset,
                'liability'   => $liability, 
              ];

    }

    public function printBalsheet(string $date_to)
    {
        $get_report = $this->getBalsheet($date_to);

        $date_to = new DateTime($date_to);




        return view('print.balsheet_report', [
                                                'date_to'      => $date_to,
                                                'asset'        => $get_report['asset'],
                                                'liability'    => $get_report['liability'],
                                             ]);
    }


}
     
       

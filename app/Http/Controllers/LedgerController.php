<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ledger;
use App\Account;
use DB;
use DateTime;
use Auth;


class LedgerController extends Controller
{
    function __construct()
    {
      $this->middleware('JWT');
    } 

    public static function getBalance(int $acct_id, $date_from = 0, $date_to = 0)
    {
      $ledger = Ledger::where('acct_one_id', $acct_id)
              ->selectRaw('IFNULL(SUM(IF(crdr_id = 1, amount, 0)), 0) credit, IFNULL(SUM(IF(crdr_id = 2, amount, 0)), 0) debit');
              
              if ($date_from != 0) 
              {
                  $ledger = $ledger->where('enter_date', '<', $date_from);
              }
              if ($date_to != 0) 
              {
                  $ledger = $ledger->where('enter_date', '<=', $date_to);
              }

         $ledger =  $ledger->first();

      $total = $ledger->credit  - $ledger->debit;

     return $total;

    }

    public function getReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = DB::table('ledgers as o')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->leftJoin('transactypes as t', 't.id', '=', 'o.transactype_id')
                        ->select(
                          DB::raw(
                                  'IF(o.crdr_id = 1, o.amount, 0) credit, IF(o.crdr_id = 2, o.amount, 0) debit, o.enter_date enter_date, o.descp descp, a.name acct_name, a.name acct_name, t.name tran_name'
                                )
                        )
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id);

                          if ($date_from != '') 
                          {
                              $get_report = $get_report->where('o.enter_date', '>=', $date_from);
                          } 

                          if ($date_to != '') 
                          {
                              $get_report = $get_report->where('o.enter_date', '<=', $date_to);
                          }

                          if ($acct_id != 0) 
                          {
                              $get_report = $get_report->where('o.acct_one_id', $acct_id);
                          }
                          
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function printReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = $this->getReport($date_from, $date_to, $acct_id);

      $open_bal = static::getBalance($acct_id, $date_from);

      $acct_name = "";
      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      if ($acct_id != 0) 
      {
       $get_acct = \App\Account::find($acct_id);
       $acct_name = $get_acct->name;
      }

      return view('print.ledger_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                              'open_bal'      => $open_bal,
                                           ]);
    }


    public function printAcctBal(Account $acct, string $date_to)
    {
      $open_bal = static::getBalance($acct->id, 0, $date_to);

      return view('print.acctbal_report', [
                                              'get_acct'      => $acct,
                                              'date_to'       => $date_to,
                                              'open_bal'      => $open_bal,
                                           ]);
    }


}

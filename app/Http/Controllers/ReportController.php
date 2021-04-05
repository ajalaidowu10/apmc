<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ReportController extends Controller
{
    // function __construct()
    // {
    //   $this->middleware('JWT');
    // } 

    public function getStock(string $date_to, int $item_id = 0)
    {
      $purchase_report = DB::table('items as t')
                        ->leftJoin('purchase_orders as oi', 'oi.id', '=', 'o.purchase_order_id')
                        ->leftJoin('items as t', 't.id', '=', 'o.item_id')
                        ->select(
                          DB::raw(
                                  ' t.name item_name, o.qty'
                                )
                        )
                        ->where('o.deleted_at', '=', null)
                        ->where('oi.deleted_at', '=', null)
                        ->where('o.del_record', '=', 0)
                        ->where('oi.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->where('oi.finyear_id', '=', Auth::guard('admin')->user()->finyear_id)
                        ->groupBy('o.item_id');

     




      
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DateTime;

class ReportController extends Controller
{
    // function __construct()
    // {
    //   $this->middleware('JWT');
    // } 

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

}
     
       

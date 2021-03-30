<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalesOrderRequest;
use App\Http\Resources\SalesOrderResource;
use Symfony\Component\HttpFoundation\Response;
use App\SalesOrder;
use App\SalesOrderItem;
use App\Ledger;
use Auth;
use DB;
use DateTime;

class SalesOrderController extends Controller
{   
    function __construct()
    {
      $this->middleware('JWT');
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SalesOrderResource::collection(SalesOrder::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesOrderRequest $request)
    {

        $sales_order_items = $request->input('sales_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        DB::beginTransaction();
          try 
          {
              $salesorder = new SalesOrder($request->all());
              $salesorder->save();
              $salesorder->sales_order_items()->createMany($sales_order_items);

                Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => 1,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->total_amount,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

                Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $salesorder->acct_id,
                                'acct_two_id'       => 1,
                                'amount'            => $salesorder->total_amount,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $salesorder->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesOrder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function show(SalesOrder $salesorder)
    {
       return new SalesOrderResource($salesorder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesOrder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function update(SalesOrderRequest $request, SalesOrder $salesorder)
    {
          $salesorder->update($request->all());
          $sales_order_items = $request->input('sales_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          DB::beginTransaction();
            try 
            {

                SalesOrderItem::where('sales_order_id', $salesorder->id)->delete();
                Ledger::where('tran_id', $salesorder->id)
                              ->where('transactype_id', 3)
                              ->delete();

                $salesorder->update($request->all());
                $salesorder->sales_order_items()->createMany($sales_order_items);

                  Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => 1,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->total_amount,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $salesorder->acct_id,
                                  'acct_two_id'       => 1,
                                  'amount'            => $salesorder->total_amount,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                

             } 
            catch (Exception $e) 
            {
              DB::rollback();
              throw $e;
            }

          DB::commit();

        return response(['orderid' => $salesorder->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesOrder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesOrder $salesorder)
    {
       $salesorder->delete();
       Ledger::where('tran_id', $salesorder->id)
                     ->where('transactype_id', 3)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = DB::table('sales_order_items as o')
                        ->leftJoin('sales_orders as oi', 'oi.id', '=', 'o.sales_order_id')
                        ->leftJoin('accounts as a', 'a.id', '=', 'oi.acct_id')
                        ->leftJoin('items as t', 't.id', '=', 'o.item_id')
                        ->select(
                          DB::raw(
                                  'oi.id sno, a.name acct_name, t.name item_name, DATE_FORMAT(oi.enter_date, "%d-%m-%Y") enter_date,  o.*'
                                )
                        )
                        ->where('o.deleted_at', '=', null)
                        ->where('oi.deleted_at', '=', null)
                        ->where('o.del_record', '=', 0);

                          if ($date_from != '') 
                          {
                              $get_report = $get_report->where('oi.enter_date', '>=', $date_from);
                          } 

                          if ($date_to != '') 
                          {
                              $get_report = $get_report->where('oi.enter_date', '<=', $date_to);
                          }

                          if ($acct_id != 0) 
                          {
                              $get_report = $get_report->where('oi.acct_id', '=', $acct_id);
                          }
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function printReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = $this->getReport($date_from, $date_to, $acct_id);

      $acct_name = "";
      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      if ($acct_id != 0) 
      {
       $get_acct = \App\Account::find($acct_id);
       $acct_name = $get_acct->name;
      }

      return view('print.sales_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                           ]);
    }

    


}

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

        $sale_order_items = $request->input('sales_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        DB::beginTransaction();
          try 
          {
              $sale = new SalesOrder($request->all());
              $sale->save();
              $sale->sales_order_items()->createMany($sale_order_items);

                Ledger::create([
                                'tran_id'           => $sale->id, 
                                'transactype_id'    => 6, 
                                'acct_one_id'       => 5,
                                'acct_two_id'       => $sale->cus_acct_id,
                                'amount'            => $sale->total_amount,
                                'enter_date'        => $sale->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => $sale->descp,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

                Ledger::create([
                                'tran_id'           => $sale->id, 
                                'transactype_id'    => 6, 
                                'acct_one_id'       => $sale->cus_acct_id,
                                'acct_two_id'       => 5,
                                'amount'            => $sale->total_amount,
                                'enter_date'        => $sale->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => $sale->descp,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $sale->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesOrder  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(SalesOrder $sale)
    {
       return new SalesOrderResource($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesOrder  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(SalesOrderRequest $request, SalesOrder $sale)
    {
          $sale->update($request->all());
          $sale_order_items = $request->input('sales_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          DB::beginTransaction();
            try 
            {

                SalesOrderItem::where('sales_order_id', $sale->id)->delete();
                Ledger::where('tran_id', $sale->id)
                              ->where('transactype_id', 6)
                              ->delete();

                $sale->update($request->all());
                $sale->sales_order_items()->createMany($sale_order_items);

                  Ledger::create([
                                  'tran_id'           => $sale->id, 
                                  'transactype_id'    => 6, 
                                  'acct_one_id'       => 5,
                                  'acct_two_id'       => $sale->cus_acct_id,
                                  'amount'            => $sale->total_amount,
                                  'enter_date'        => $sale->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => $sale->descp,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $sale->id, 
                                  'transactype_id'    => 6, 
                                  'acct_one_id'       => $sale->cus_acct_id,
                                  'acct_two_id'       => 5,
                                  'amount'            => $sale->total_amount,
                                  'enter_date'        => $sale->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => $sale->descp,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                

             } 
            catch (Exception $e) 
            {
              DB::rollback();
              throw $e;
            }

          DB::commit();

        return response(['orderid' => $sale->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesOrder  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesOrder $sale)
    {
       $sale->delete();
       Ledger::where('tran_id', $sale->id)
                     ->where('transactype_id', 6)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function printInvoice(SalesOrder $sale)
    {
      return view('print.sales_invoice', ['data' => $sale]);
    }

    


}

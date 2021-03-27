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

    public function printInvoice(SalesOrder $salesorder)
    {
      return view('print.sales_invoice', ['data' => $salesorder]);
    }

    


}

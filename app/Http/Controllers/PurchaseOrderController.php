<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\PurchaseOrderResource;
use Symfony\Component\HttpFoundation\Response;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\Ledger;
use Auth;
use DB;

class PurchaseOrderController extends Controller
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
        return PurchaseOrderResource::collection(PurchaseOrder::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {

        $purchase_order_items = $request->input('purchase_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        DB::beginTransaction();
          try 
          {
              $purchaseorder = new PurchaseOrder($request->all());
              $purchaseorder->save();
              $purchaseorder->purchase_order_items()->createMany($purchase_order_items);

                Ledger::create([
                                'tran_id'           => $purchaseorder->id, 
                                'transactype_id'    => 2, 
                                'acct_one_id'       => 2,
                                'acct_two_id'       => $purchaseorder->acct_id,
                                'amount'            => $purchaseorder->total_amount,
                                'enter_date'        => $purchaseorder->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

                Ledger::create([
                                'tran_id'           => $purchaseorder->id, 
                                'transactype_id'    => 2, 
                                'acct_one_id'       => $purchaseorder->acct_id,
                                'acct_two_id'       => 2,
                                'amount'            => $purchaseorder->total_amount,
                                'enter_date'        => $purchaseorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $purchaseorder->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseorder)
    {
       return new PurchaseOrderResource($purchaseorder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, PurchaseOrder $purchaseorder)
    {
          $purchaseorder->update($request->all());
          $purchase_order_items = $request->input('purchase_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          DB::beginTransaction();
            try 
            {

                PurchaseOrderItem::where('purchase_order_id', $purchaseorder->id)->delete();
                Ledger::where('tran_id', $purchaseorder->id)
                              ->where('transactype_id', 2)
                              ->delete();

                $purchaseorder->update($request->all());
                $purchaseorder->purchase_order_items()->createMany($purchase_order_items);

                  Ledger::create([
                                  'tran_id'           => $purchaseorder->id, 
                                  'transactype_id'    => 2, 
                                  'acct_one_id'       => 2,
                                  'acct_two_id'       => $purchaseorder->acct_id,
                                  'amount'            => $purchaseorder->total_amount,
                                  'enter_date'        => $purchaseorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $purchaseorder->id, 
                                  'transactype_id'    => 2, 
                                  'acct_one_id'       => $purchaseorder->acct_id,
                                  'acct_two_id'       => 2,
                                  'amount'            => $purchaseorder->total_amount,
                                  'enter_date'        => $purchaseorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                

             } 
            catch (Exception $e) 
            {
              DB::rollback();
              throw $e;
            }

          DB::commit();

        return response(['orderid' => $purchaseorder->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseorder)
    {
       $purchaseorder->delete();
       Ledger::where('tran_id', $purchaseorder->id)
                     ->where('transactype_id', 2)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function printInvoice(PurchaseOrder $purchaseorder)
    {
      return view('print.purchase_invoice', ['data' => $purchaseorder]);
    }

    


}

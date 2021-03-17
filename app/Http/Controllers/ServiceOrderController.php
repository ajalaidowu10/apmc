<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceOrderRequest;
use App\Http\Resources\ServiceOrderResource;
use Symfony\Component\HttpFoundation\Response;
use App\ServiceOrder;
use App\ServiceOrderItem;
use App\Ledger;
use Auth;
use DB;

class ServiceOrderController extends Controller
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
        return ServiceOrderResource::collection(ServiceOrder::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceOrderRequest $request)
    {

        $service_order_items = $request->input('service_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        DB::beginTransaction();
          try 
          {
              $serviceorder = new ServiceOrder($request->all());
              $serviceorder->save();
              $serviceorder->service_order_items()->createMany($service_order_items);

                Ledger::create([
                                'tran_id'           => $serviceorder->id, 
                                'transactype_id'    => 7, 
                                'acct_one_id'       => 7,
                                'acct_two_id'       => $serviceorder->cus_acct_id,
                                'amount'            => $serviceorder->total_amount,
                                'enter_date'        => $serviceorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => $serviceorder->descp,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

                Ledger::create([
                                'tran_id'           => $serviceorder->id, 
                                'transactype_id'    => 7, 
                                'acct_one_id'       => $serviceorder->cus_acct_id,
                                'acct_two_id'       => 7,
                                'amount'            => $serviceorder->total_amount,
                                'enter_date'        => $serviceorder->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => $serviceorder->descp,
                                'created_by'        => Auth::guard('admin')->user()->id,
                            ]);

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $serviceorder->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceOrder  $serviceorder
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceOrder $serviceorder)
    {
       return new ServiceOrderResource($serviceorder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceOrder  $serviceorder
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceOrderRequest $request, ServiceOrder $serviceorder)
    {
          $serviceorder->update($request->all());
          $service_order_items = $request->input('service_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          DB::beginTransaction();
            try 
            {

                ServiceOrderItem::where('service_order_id', $serviceorder->id)->delete();
                Ledger::where('tran_id', $serviceorder->id)
                              ->where('transactype_id', 7)
                              ->delete();

                $serviceorder->update($request->all());
                $serviceorder->service_order_items()->createMany($service_order_items);

                  Ledger::create([
                                  'tran_id'           => $serviceorder->id, 
                                  'transactype_id'    => 7, 
                                  'acct_one_id'       => 7,
                                  'acct_two_id'       => $serviceorder->cus_acct_id,
                                  'amount'            => $serviceorder->total_amount,
                                  'enter_date'        => $serviceorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => $serviceorder->descp,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $serviceorder->id, 
                                  'transactype_id'    => 7, 
                                  'acct_one_id'       => $serviceorder->cus_acct_id,
                                  'acct_two_id'       => 7,
                                  'amount'            => $serviceorder->total_amount,
                                  'enter_date'        => $serviceorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => $serviceorder->descp,
                                  'created_by'        => Auth::guard('admin')->user()->id,
                              ]);

                

             } 
            catch (Exception $e) 
            {
              DB::rollback();
              throw $e;
            }

          DB::commit();

        return response(['orderid' => $serviceorder->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceOrder  $serviceorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $serviceorder)
    {
       $serviceorder->delete();
       Ledger::where('tran_id', $serviceorder->id)
                     ->where('transactype_id', 7)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function printInvoice(ServiceOrder $serviceorder)
    {
      return view('print.service_invoice', ['data' => $serviceorder]);
    }

    


}

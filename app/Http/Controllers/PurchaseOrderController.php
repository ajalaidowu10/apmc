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
use App\Account;
use DateTime;

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
        return PurchaseOrderResource::collection(PurchaseOrder::where('company_id', Auth::guard('admin')->user()->company_id)
                                                 ->where('finyear_id', Auth::guard('admin')->user()->finyear_id)
                                                 ->latest()->get());
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

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
        $request->merge($company_id);

        $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
        $request->merge($finyear_id);

        $sale_acct = Account::where('name', 'Sales Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();

        DB::beginTransaction();
          try 
          {
              $purchaseorder = new PurchaseOrder($request->all());
              $purchaseorder->save();
              $purchaseorder->purchase_order_items()->createMany($purchase_order_items);

                Ledger::create([
                                'tran_id'           => $purchaseorder->id, 
                                'transactype_id'    => 2, 
                                'acct_one_id'       => $sale_acct->id,
                                'acct_two_id'       => $purchaseorder->acct_id,
                                'amount'            => $purchaseorder->total_amount,
                                'enter_date'        => $purchaseorder->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                'created_by'        => $purchaseorder->created_by,
                                'company_id'        => $purchaseorder->company_id,
                                'finyear_id'        => $purchaseorder->finyear_id,
                            ]);

                Ledger::create([
                                'tran_id'           => $purchaseorder->id, 
                                'transactype_id'    => 2, 
                                'acct_one_id'       => $purchaseorder->acct_id,
                                'acct_two_id'       => $sale_acct->id,
                                'amount'            => $purchaseorder->total_amount,
                                'enter_date'        => $purchaseorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                'created_by'        => $purchaseorder->created_by,
                                'company_id'        => $purchaseorder->company_id,
                                'finyear_id'        => $purchaseorder->finyear_id,
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

          $sale_acct = Account::where('name', 'Sales Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

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
                                  'acct_one_id'       => $sale_acct->id,
                                  'acct_two_id'       => $purchaseorder->acct_id,
                                  'amount'            => $purchaseorder->total_amount,
                                  'enter_date'        => $purchaseorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                  'created_by'        => $purchaseorder->created_by,
                                  'company_id'        => $purchaseorder->company_id,
                                  'finyear_id'        => $purchaseorder->finyear_id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $purchaseorder->id, 
                                  'transactype_id'    => 2, 
                                  'acct_one_id'       => $purchaseorder->acct_id,
                                  'acct_two_id'       => $sale_acct->id,
                                  'amount'            => $purchaseorder->total_amount,
                                  'enter_date'        => $purchaseorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Purchase From '.$purchaseorder->acct->name,
                                  'created_by'        => $purchaseorder->created_by,
                                  'company_id'        => $purchaseorder->company_id,
                                  'finyear_id'        => $purchaseorder->finyear_id,
                                  
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

    public function getReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = DB::table('purchase_order_items as o')
                        ->leftJoin('purchase_orders as oi', 'oi.id', '=', 'o.purchase_order_id')
                        ->leftJoin('accounts as a', 'a.id', '=', 'oi.acct_id')
                        ->leftJoin('items as t', 't.id', '=', 'o.item_id')
                        ->select(
                          DB::raw(
                                  'oi.id sno, a.name acct_name, t.name item_name, DATE_FORMAT(oi.enter_date, "%d-%m-%Y") enter_date, oi.invoice_no invoice_no, o.*'
                                )
                        )
                        ->where('o.deleted_at', '=', null)
                        ->where('oi.deleted_at', '=', null)
                        ->where('o.del_record', '=', 0)
                        ->where('oi.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->where('oi.finyear_id', '=', Auth::guard('admin')->user()->finyear_id);

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

      return view('print.purchase_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                           ]);
    }

    


}

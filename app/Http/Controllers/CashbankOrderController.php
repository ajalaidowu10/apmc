<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CashbankOrderRequest;
use App\Http\Resources\CashbankOrderResource;
use App\Http\Resources\CashbankOrderItemResource;
use Symfony\Component\HttpFoundation\Response;
use App\CashbankOrder;
use App\CashbankOrderItem;
use App\Ledger;
use Auth;
use DB;
use DateTime;
use App\Http\Controllers\LedgerController;

class CashbankOrderController extends Controller
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
        return CashbankOrderResource::collection(CashbankOrder::where('company_id', Auth::guard('admin')->user()->company_id)
                                                 ->where('finyear_id', Auth::guard('admin')->user()->finyear_id)
                                                 ->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashbankOrderRequest $request)
    {

        $cashbank_order_items = $request->input('cashbank_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
        $request->merge($company_id);

        $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
        $request->merge($finyear_id);

        DB::beginTransaction();
          try 
          {
              $cashbank_order = new CashbankOrder($request->all());
              $cashbank_order->save();

              foreach ($cashbank_order_items as $data) 
              {
                $cashbank_item = $cashbank_order->cashbank_order_items()->create($data);

                Ledger::create([
                                'tran_id'           => $cashbank_order->id, 
                                'transactype_id'    => 4, 
                                'acct_one_id'       => $cashbank_order->acct_one_id,
                                'acct_two_id'       => $cashbank_item->acct_two_id,
                                'amount'            => $cashbank_item->amount,
                                'enter_date'        => $cashbank_order->enter_date,
                                'crdr_id'           => $cashbank_order->cashbank_type_id == 1 ? 2 : 1,
                                'descp'             => $cashbank_item->descp,
                                'created_by'        => $cashbank_order->created_by,
                                'company_id'        => $cashbank_order->company_id,
                                'finyear_id'        => $cashbank_order->finyear_id,
                            ]);

                Ledger::create([
                                'tran_id'           => $cashbank_order->id, 
                                'transactype_id'    => 4, 
                                'acct_one_id'       => $cashbank_item->acct_two_id,
                                'acct_two_id'       => $cashbank_order->acct_one_id,
                                'amount'            => $cashbank_item->amount,
                                'enter_date'        => $cashbank_order->enter_date,
                                'crdr_id'           => $cashbank_order->cashbank_type_id == 1 ? 1 : 2,
                                'descp'             => $cashbank_item->descp,
                                'created_by'        => $cashbank_order->created_by,
                                'company_id'        => $cashbank_order->company_id,
                                'finyear_id'        => $cashbank_order->finyear_id,
                            ]);
              }

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $cashbank_order->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashbankOrder  $cashbank
     * @return \Illuminate\Http\Response
     */
    public function show(CashbankOrder $cashbank)
    {
       return new CashbankOrderResource($cashbank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashbankOrder  $cashbank
     * @return \Illuminate\Http\Response
     */
    public function update(CashbankOrderRequest $request, CashbankOrder $cashbank)
    {
          $cashbank->update($request->all());
          $cashbank_order_items = $request->input('cashbank_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
          $request->merge($company_id);

          $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
          $request->merge($finyear_id);

          DB::beginTransaction();
            try 
            {
                $cashbank->update($request->all());
                CashbankOrderItem::where('cashbank_order_id', $cashbank->id)->delete();
                Ledger::where('tran_id', $cashbank->id)
                              ->where('transactype_id', 4)
                              ->delete();

                foreach ($cashbank_order_items as $data) 
                {
                  $cashbank_item = $cashbank->cashbank_order_items()->create($data);

                  if ($data['del_record'] == 0) 
                  {
                    Ledger::create([
                                    'tran_id'           => $cashbank->id, 
                                    'transactype_id'    => 4, 
                                    'acct_one_id'       => $cashbank->acct_one_id,
                                    'acct_two_id'       => $cashbank_item->acct_two_id,
                                    'amount'            => $cashbank_item->amount,
                                    'enter_date'        => $cashbank->enter_date,
                                    'crdr_id'           => $cashbank->cashbank_type_id == 1 ? 2 : 1,
                                    'descp'             => $cashbank_item->descp,
                                    'created_by'        => $cashbank_order->created_by,
                                    'company_id'        => $cashbank_order->company_id,
                                    'finyear_id'        => $cashbank_order->finyear_id,
                                ]);

                    Ledger::create([
                                    'tran_id'           => $cashbank->id, 
                                    'transactype_id'    => 4, 
                                    'acct_one_id'       => $cashbank_item->acct_two_id,
                                    'acct_two_id'       => $cashbank->acct_one_id,
                                    'amount'            => $cashbank_item->amount,
                                    'enter_date'        => $cashbank->enter_date,
                                    'crdr_id'           => $cashbank->cashbank_type_id == 1 ? 1 : 2,
                                    'descp'             => $cashbank_item->descp,
                                    'created_by'        => $cashbank_order->created_by,
                                    'company_id'        => $cashbank_order->company_id,
                                    'finyear_id'        => $cashbank_order->finyear_id,
                                ]);
                  } 
                  
                }

             } 
            catch (Exception $e) 
            {
              DB::rollback();
              throw $e;
            }

          DB::commit();

        return response(['orderid' => $cashbank->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashbankOrder  $cashbank
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashbankOrder $cashbank)
    {
       $cashbank->delete();
       Ledger::where('tran_id', $cashbank->id)
                     ->where('transactype_id', 4)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function printReceipt(CashbankOrderItem $cashbank)
    {
      return view('print.cashbank_receipt', ['data' => $cashbank]);
    }

    public function getReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = DB::table('cashbank_orders as o')
                        ->leftJoin('cashbank_order_items as oi', 'oi.cashbank_order_id', '=', 'o.id')
                        ->leftJoin('accounts as a1', 'a1.id', '=', 'oi.acct_two_id')
                        ->leftJoin('accounts as a2', 'a2.id', '=', 'o.acct_one_id')
                        ->leftJoin('cashbank_types', 'cashbank_types.id', '=', 'o.cashbank_type_id')
                        ->select(
                          DB::raw(
                                  'IF(o.cashbank_type_id = 2, oi.amount, 0) credit, IF(o.cashbank_type_id = 1, oi.amount, 0) debit, o.enter_date enter_date, oi.descp descp, cashbank_types.name  type_name, a1.name acct_name, a2.name acct1_name '
                                )
                        )
                        ->where('o.deleted_at', '=', null)
                        ->where('oi.deleted_at', '=', null)
                        ->where('oi.del_record', '=', 0)
                        ->where('o.company_id', '=', Auth::guard('admin')->user()->company_id)
                        ->where('o.finyear_id', '=', Auth::guard('admin')->user()->finyear_id);

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
      $open_bal = LedgerController::getBalance($acct_id, $date_from);

      $acct_name = "";
      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      if ($acct_id != 0) 
      {
       $get_acct = \App\Account::find($acct_id);
       $acct_name = $get_acct->name;
      }

      return view('print.cashbank_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                              'open_bal'      => $open_bal,
                                           ]);
    }

    


}

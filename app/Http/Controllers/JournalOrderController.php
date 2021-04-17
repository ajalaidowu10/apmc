<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JournalOrderRequest;
use App\Http\Resources\JournalOrderResource;
use Symfony\Component\HttpFoundation\Response;
use App\JournalOrder;
use App\JournalOrderItem;
use App\Ledger;
use Auth;
use DB;
use DateTime;

class JournalOrderController extends Controller
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
        return JournalOrderResource::collection(JournalOrder::where('company_id', Auth::guard('admin')->user()->company_id)
                                                 ->where('finyear_id', Auth::guard('admin')->user()->finyear_id)
                                                 ->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JournalOrderRequest $request)
    {

        $journal_order_items = $request->input('journal_order_items');
        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
        $request->merge($company_id);

        $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
        $request->merge($finyear_id);

        DB::beginTransaction();
          try 
          {
              $journal_order = new JournalOrder($request->all());
              $journal_order->save();

              foreach ($journal_order_items as $data) 
              {
                $journal_item = $journal_order->journal_order_items()->create($data);

                Ledger::create([
                                'tran_id'           => $journal_order->id, 
                                'transactype_id'    => 5, 
                                'acct_one_id'       => $journal_item->acct_one_id,
                                'amount'            => $journal_item->amount,
                                'enter_date'        => $journal_order->enter_date,
                                'crdr_id'           => $journal_item->crdr_id,
                                'descp'             => $journal_item->descp,
                                'created_by'        => $journal_order->created_by,
                                'company_id'        => $journal_order->company_id,
                                'finyear_id'        => $journal_order->finyear_id,
                            ]);
              }

           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $journal_order->id], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JournalOrder  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(JournalOrder $journal)
    {
       return new JournalOrderResource($journal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JournalOrder  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(JournalOrderRequest $request, JournalOrder $journal)
    {
          $journal->update($request->all());
          $journal_order_items = $request->input('journal_order_items');
          $created_by = ['created_by' => Auth::guard('admin')->user()->id];
          $request->merge($created_by);

          DB::beginTransaction();
            try 
            {
                $journal->update($request->all());
                JournalOrderItem::where('journal_order_id', $journal->id)->delete();
                Ledger::where('tran_id', $journal->id)
                              ->where('transactype_id', 5)
                              ->delete();

                foreach ($journal_order_items as $data) 
                {
                  $journal_item = $journal->journal_order_items()->create($data);

                  if ($data['del_record'] == 0) 
                  {
                    Ledger::create([
                                    'tran_id'           => $journal->id, 
                                    'transactype_id'    => 5, 
                                    'acct_one_id'       => $journal_item->acct_one_id,
                                    'amount'            => $journal_item->amount,
                                    'enter_date'        => $journal->enter_date,
                                    'crdr_id'           => $journal_item->crdr_id,
                                    'descp'             => $journal_item->descp,
                                    'created_by'        => $journal_order->created_by,
                                    'company_id'        => $journal_order->company_id,
                                    'finyear_id'        => $journal_order->finyear_id,
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

        return response(['orderid' => $journal->id], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JournalOrder  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(JournalOrder $journal)
    {
       $journal->delete();
       Ledger::where('tran_id', $journal->id)
                     ->where('transactype_id', 5)
                     ->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $get_report = DB::table('journal_order_items as o')
                        ->leftJoin('journal_orders as oi', 'oi.id', '=', 'o.journal_order_id')
                        ->leftJoin('accounts as a', 'a.id', '=', 'o.acct_one_id')
                        ->select(
                          DB::raw(
                                  'IF(o.crdr_id = 1, o.amount, 0) credit, IF(o.crdr_id = 2, o.amount, 0) debit, oi.enter_date enter_date, o.descp descp, a.name acct_name, a.name acct_name, o.journal_order_id order_id'
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
                              $get_order = JournalOrderItem::where('acct_one_id', $acct_id)->pluck('journal_order_id');
                              $get_report = $get_report->whereIn('o.journal_order_id', $get_order);
                          }
      $get_report = $get_report->get();                          
      return $get_report;
    }

    public function printReport(string $date_from='', string $date_to='', int $acct_id = 0)
    {
      $company = Auth::guard('admin')->user()->company;
      $get_report = $this->getReport($date_from, $date_to, $acct_id);

      $acct_name = "";
      $date_from = new DateTime($date_from);
      $date_to = new DateTime($date_to);

      if ($acct_id != 0) 
      {
       $get_acct = \App\Account::find($acct_id);
       $acct_name = $get_acct->name;
      }

      return view('print.journal_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                              'company'       => $company,
                                           ]);
    }


}

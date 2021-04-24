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
use App\Account;

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
        return SalesOrderResource::collection(SalesOrder::where('company_id', Auth::guard('admin')->user()->company_id)
                                                 ->where('finyear_id', Auth::guard('admin')->user()->finyear_id)
                                                 ->latest()->get());
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

        $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
        $request->merge($company_id);

        $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
        $request->merge($finyear_id);

        $sale_acct = Account::where('name', 'Sales Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();

        $comm_acct = Account::where('name', 'Commission Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();

        $levy_acct = Account::where('name', 'Levy Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();


        $apmc_acct = Account::where('name', 'Apmc Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();

        $map_levy_acct = Account::where('name', 'Map Levy Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();

        $other_charges_acct = Account::where('name', 'Other Charges Account')
                             ->where('company_id', Auth::guard('admin')->user()->company_id)
                             ->first();


        DB::beginTransaction();
          try 
          {
              $salesorder = new SalesOrder($request->all());
              $salesorder->save();
              $salesorder->sales_order_items()->createMany($sales_order_items);

                Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $sale_acct->id,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->sales_amount,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
                            ]);

                Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $comm_acct->id,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->comm,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
                            ]);

                 Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $levy_acct->id,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->levy,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
                            ]);

                  Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $apmc_acct->id,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->apmc,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
                            ]);

                  Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $map_levy_acct->id,
                                'acct_two_id'       => $salesorder->acct_id,
                                'amount'            => $salesorder->map_levy,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 1,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
                            ]);

                  Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $other_charges_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->other_charges,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);


                Ledger::create([
                                'tran_id'           => $salesorder->id, 
                                'transactype_id'    => 3, 
                                'acct_one_id'       => $salesorder->acct_id,
                                'acct_two_id'       => $sale_acct->id,
                                'amount'            => $salesorder->total_amount,
                                'enter_date'        => $salesorder->enter_date,
                                'crdr_id'           => 2,
                                'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                'created_by'        => $salesorder->created_by,
                                'company_id'        => $salesorder->company_id,
                                'finyear_id'        => $salesorder->finyear_id,
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

          $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
          $request->merge($company_id);

          $finyear_id = ['finyear_id' => Auth::guard('admin')->user()->finyear_id];
          $request->merge($finyear_id);


          $sale_acct = Account::where('name', 'Sales Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

          $comm_acct = Account::where('name', 'Commission Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

          $levy_acct = Account::where('name', 'Levy Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();


          $apmc_acct = Account::where('name', 'Apmc Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

          $map_levy_acct = Account::where('name', 'Map Levy Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

          $other_charges_acct = Account::where('name', 'Other Charges Account')
                               ->where('company_id', Auth::guard('admin')->user()->company_id)
                               ->first();

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
                                  'acct_one_id'       => $sale_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->sales_amount,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);

                  Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $comm_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->comm,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);

                   Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $levy_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->levy,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);

                    Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $apmc_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->apmc,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);

                    Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $map_levy_acct->id,
                                  'acct_two_id'       => $salesorder->acct_id,
                                  'amount'            => $salesorder->map_levy,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 1,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
                              ]);

                    Ledger::create([
                                    'tran_id'           => $salesorder->id, 
                                    'transactype_id'    => 3, 
                                    'acct_one_id'       => $other_charges_acct->id,
                                    'acct_two_id'       => $salesorder->acct_id,
                                    'amount'            => $salesorder->other_charges,
                                    'enter_date'        => $salesorder->enter_date,
                                    'crdr_id'           => 2,
                                    'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                    'created_by'        => $salesorder->created_by,
                                    'company_id'        => $salesorder->company_id,
                                    'finyear_id'        => $salesorder->finyear_id,
                                ]);


                  Ledger::create([
                                  'tran_id'           => $salesorder->id, 
                                  'transactype_id'    => 3, 
                                  'acct_one_id'       => $salesorder->acct_id,
                                  'acct_two_id'       => $sale_acct->id,
                                  'amount'            => $salesorder->total_amount,
                                  'enter_date'        => $salesorder->enter_date,
                                  'crdr_id'           => 2,
                                  'descp'             => 'Item Sales From '.$salesorder->acct->name,
                                  'created_by'        => $salesorder->created_by,
                                  'company_id'        => $salesorder->company_id,
                                  'finyear_id'        => $salesorder->finyear_id,
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

      return view('print.sales_report', [
                                              'get_report'    => $get_report,
                                              'date_from'     => $date_from,
                                              'date_to'       => $date_to,
                                              'acct_id'       => $acct_id,
                                              'acct_name'     => $acct_name,
                                              'company'       => $company,
                                           ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
   protected $fillable = [
                              'tran_id', 'transactype_id', 'acct_one_id', 
                              'enter_date', 'acct_two_id', 'amount', 'crdr_id', 
                              'descp', 'is_visible', 'created_by', 'company_id',
                              'finyear_id',
                         ];

  public function transaction()
  {
   return $this->belongsTo('App\Transaction');
  }  

  public function crdr()
  {
   return $this->belongsTo('App\Crdr');
  } 

  public function company()
  {
   return $this->belongsTo('App\Company');
  }

  public function finyear()
  {
   return $this->belongsTo('App\FinancialYear', 'finyear_id');
  }        

  public function acct_one()
  {
    return $this->belongsTo('App\Account', 'acct_one_id');
  } 

  public function acct_two()
  {
    return $this->belongsTo('App\Account', 'acct_two_id');
  }

  public function created_by()
  {
    return $this->belongsTo('App\Admin', 'created_by');
  }    

  


}

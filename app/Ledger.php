<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
   protected $fillable = [
                              'tran_id', 'transactype_id', 'acct_one_id', 
                              'enter_date', 'acct_two_id', 'amount', 'crdr_id', 
                              'descp', 'is_visible', 'created_by'
                         ];

  public function transaction()
  {
   return $this->belongsTo('App\Transaction');
  }  

  public function crdr()
  {
   return $this->belongsTo('App\Crdr');
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

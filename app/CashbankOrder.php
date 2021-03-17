<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashbankOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
                            'cashbank_type_id', 'payment_type_id', 'acct_one_id', 
                            'total_amount', 'enter_date', 'created_by', 'deleted_at',
                          ];
    protected static function boot()
    {
      parent::boot();
      static::deleting(function ($cashbank) {
          $cashbank->cashbank_order_items()->each(function ($cashbank_order_item)
          {
            $cashbank_order_item->delete();
          });
      });
    }                          
    public function cashbank_type()
    {
      return $this->belongsTo('App\CashbankType');
    }

    public function payment_type()
    {
      return $this->belongsTo('App\PaymentType');
    }

    public function acct_one()
    {
      return $this->belongsTo('App\Account', 'acct_one_id');
    } 

    public function cashbank_order_items()
    {
      return $this->hasMany('App\CashbankOrderItem');
    }
}

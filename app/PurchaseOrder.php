<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
                            'acct_id', 'invoice_no', 'enter_date', 'total_amount', 'motor_no', 
                            'comm', 'other_charges', 'apmc', 
                            'total_qty', 'created_by', 'status_id', 'deleted_at'
                          ];

    public function purchase_order_items()
    {
      return $this->hasMany('App\PurchaseOrderItem');
    }

    public function created_by()
    {
      return $this->belongsTo('App\Admin');
    }

    public function acct()
    {
      return $this->belongsTo('App\Account', 'acct_id');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}

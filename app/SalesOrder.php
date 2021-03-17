<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['cus_acct_id', 'enter_date', 'total_amount', 'descp', 'total_qty', 'created_by', 'status_id', 'deleted_at'];

   	public function sales_order_items()
   	{
   	  return $this->hasMany('App\SalesOrderItem');
   	}

    public function created_by()
    {
      return $this->belongsTo('App\Admin');
    }

    public function cus_acct()
    {
      return $this->belongsTo('App\Account', 'cus_acct_id');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}

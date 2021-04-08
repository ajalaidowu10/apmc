<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
                            'acct_id', 'invoice_no', 'enter_date', 'total_amount', 'motor_no', 
                            'other_charges', 'levy', 'apmc', 'map_levy', 'comm', 'tds',
                            'total_qty', 'created_by', 'status_id', 'deleted_at',
                            'finyear_id', 'company_id', 'sales_amount',
                          ];
    public static function boot() {
      parent::boot();
      self::deleting(function($salesorder) { 
           $salesorder->sales_order_items()->each(function($sales_order_items) {
              $sales_order_items->delete(); 
           });
           
      });
    }

    public function sales_order_items()
    {
      return $this->hasMany('App\SalesOrderItem');
    }

    public function created_by()
    {
      return $this->belongsTo('App\Admin');
    }

    public function acct()
    {
      return $this->belongsTo('App\Account');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
                            'sales_order_id', 'item_id', 'qty', 'grwt', 
                            'rate', 'del_record', 'amount', 'levy', 'map_levy',
                            'apmc', 'comm', 'tds', 'final_amount', 'item_exp_object', 'deleted_at',
                            'finyear_id', 'company_id',
                        ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sales_order_items) {
            $sales_order_items->item_exp_object = json_encode($sales_order_items->item_exp_object);
        });
    }

    public function sales_order()
    {
      return $this->belongsTo('App\SalesOrder');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

}

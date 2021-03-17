<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['sales_order_id', 'item_id', 'qty', 'item_price', 'del_record', 'amount', 'deleted_at'];

    public function sales_order()
    {
      return $this->belongsTo('App\SalesOrder');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
                            'purchase_order_id', 'item_id', 'qty', 'grwt', 
                            'rate', 'del_record', 'amount', 'levy', 'map_levy',
                            'apmc', 'comm', 'tds', 'final_amount', 'deleted_at'
                        ];

    public function purchase_order()
    {
      return $this->belongsTo('App\PurchaseOrder');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }


}

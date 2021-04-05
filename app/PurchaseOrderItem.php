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
                            'apmc', 'comm', 'tds', 'final_amount', 'item_exp_object', 'deleted_at',
                            'finyear_id', 'company_id',
                        ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase_order_items) {
            $purchase_order_items->item_exp_object = json_encode($purchase_order_items->item_exp_object);
        });
    }

    public function purchase_order()
    {
      return $this->belongsTo('App\PurchaseOrder');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

}

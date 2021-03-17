<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['service_order_id', 'service_id', 'qty', 'service_price', 'del_record', 'amount', 'deleted_at'];

    public function service_order()
    {
      return $this->belongsTo('App\ServiceOrder');
    }

    public function service()
    {
      return $this->belongsTo('App\Service');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
   use SoftDeletes;
   protected $fillable = ['item_group_id', 'name', 'unit', 'weight_pb', 'status_id','deleted_at'];

   public function item_group()
   {
     return $this->belongsTo('App\ItemGroup');
   }
   public function status()
   {
     return $this->belongsTo('App\Status');
   }
}

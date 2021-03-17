<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemExp extends Model
{
   use SoftDeletes;
   protected $fillable = [
                           'item_id', 'enterdate', 'unit',
                           'weight_pb', 'comm', 'p_hamali',
                           'b_hamali', 'p_levy',
                           'b_levy', 'apmc', 'map_levy', 
                           'discount', 'tolai',
                           'status_id','deleted_at'
                         ];

   public function item()
   {
     return $this->belongsTo('App\Item');
   }
   public function status()
   {
     return $this->belongsTo('App\Status');
   }
}

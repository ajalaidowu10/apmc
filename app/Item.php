<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
   use SoftDeletes;
   protected $fillable = ['name', 'unit', 'weight_pb', 'status_id','deleted_at', 'company_id'];

   public function status()
   {
     return $this->belongsTo('App\Status');
   }

   public function item_exps()
   {
   		return $this->hasMany('App\ItemExp');
   }
}

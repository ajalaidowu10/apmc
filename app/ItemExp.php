<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemExp extends Model
{
   use SoftDeletes;
   protected $fillable = [
                           'item_id', 'enter_date', 
                           'comm', 'p_hamali',
                           'b_hamali', 'p_levy',
                           'b_levy', 'apmc', 'map_levy', 
                           'discount', 'tolai', 'tds',
                           'status_id','deleted_at',
                           'finyear_id', 'company_id',
                         ];

   public function item()
   {
     return $this->belongsTo('App\Item');
   }
   public function status()
   {
     return $this->belongsTo('App\Status');
   }
   public function finyear()
   {
     return $this->belongsTo('App\FinancialYear', 'finyear_id');
   }
   public function company()
   {
     return $this->belongsTo('App\Company');
   }
}

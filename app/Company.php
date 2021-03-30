<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
    						 'name', 'phone', 'email', 'address', 'status_id', 'invoice_header_path', 
    						 'invoice_footer_path', 'receipt_header_path', 'receipt_footer_path'
    					  ];

   public function status()
   {
     return $this->belongsTo('App\Status');
   }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
    						 'name', 'phone', 'email', 'address', 'status_id', 'created_by', 'invheader_path', 
    						 'invfooter_path', 'recheader_path', 'recfooter_path'
    					  ];

   public function status()
   {
     return $this->belongsTo('App\Status');
   }
}

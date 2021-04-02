<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
    						 'name', 'phone', 'email', 'address', 'status_id', 'created_by', 'invheader', 
    						 'invfooter', 'recheader', 'recfooter'
    					  ];

   public function status()
   {
     return $this->belongsTo('App\Status');
   }

   public function getInvheaderPathAttribute()
   {
       return $this->invheader ? asset('apmc/images/company/'.$this->invheader) : asset('apmc/images/company/default.png');
   }

   public function getInvfooterPathAttribute()
   {
       return $this->invheader ? asset('apmc/images/company/'.$this->invheader) : asset('apmc/images/company/default.png');
   }

   public function getRecheaderPathAttribute()
   {
       return $this->recheader ? asset('apmc/images/company/'.$this->recheader) : asset('apmc/images/company/default.png');
   }

   public function getRecfooterPathAttribute()
   {
       return $this->recheader ? asset('apmc/images/company/'.$this->recheader) : asset('apmc/images/company/default.png');
   }

}

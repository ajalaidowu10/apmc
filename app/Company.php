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

   public function finyears()
   {
     return $this->hasMany('App\FinancialYear');
   }

   public function getInvheaderPathAttribute()
   {
       if ($this->invheader) 
       {
         return asset(\Storage::url('images/company/'.$this->invheader));
       } 
       else 
       {
         return asset('images/default.png');
       }
       
   }

   public function getInvfooterPathAttribute()
   {
       if ($this->invfooter) 
       {
         return asset(\Storage::url('images/company/'.$this->invfooter));
       } 
       else 
       {
         return asset('images/default.png');
       }
   }

   public function getRecheaderPathAttribute()
   {
      if ($this->recheader) 
      {
        return asset(\Storage::url('images/company/'.$this->recheader));
      } 
      else 
      {
        return asset('images/default.png');
      }
   }

   public function getRecfooterPathAttribute()
   {
      if ($this->recfooter) 
      {
        return asset(\Storage::url('images/company/'.$this->recfooter));
      } 
      else 
      {
        return asset('images/default.png');
      }
   }

}

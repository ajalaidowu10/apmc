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
       return asset(\Storage::url($this->invheader ? 'images/company/'.$this->invheader : 'images/company/default.png'));
   }

   public function getInvfooterPathAttribute()
   {
       return asset(\Storage::url($this->invheader ? 'images/company/'.$this->invheader : 'images/company/default.png'));
   }

   public function getRecheaderPathAttribute()
   {
       return asset(\Storage::url($this->recheader ? 'images/company/'.$this->recheader : 'images/company/default.png'));
   }

   public function getRecfooterPathAttribute()
   {
       return asset(\Storage::url($this->recheader ? 'images/company/'.$this->recheader : 'images/company/default.png'));
   }

}

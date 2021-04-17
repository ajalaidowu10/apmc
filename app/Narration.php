<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Narration extends Model
{
   	use SoftDeletes;
   	
    protected $fillable = ['name', 'company_id'];
}

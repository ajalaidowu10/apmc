<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiniancialYear extends Model
{
    use SoftDeletes;

    protected $fillable = ['company_id', 'from', 'to', 'status_id'];

    public function status()
    {
      return $this->belongsTo('App\Status');
    }

    public function company()
    {
      return $this->belongsTo('App\Company');
    }
}

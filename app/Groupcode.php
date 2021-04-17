<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Groupcode extends Model
{
    use SoftDeletes;
    protected $fillable = ['parent_groupcode_id', 'name', 'descp', 'status_id', 'created_by', 'is_visible', 'deleted_at', 'company_id'];

    public function parent_groupcode()
    {
      return $this->belongsTo('App\ParentGroupcode');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'created_by');
    }

    
}

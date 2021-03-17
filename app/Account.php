<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_type_id',  'name', 'opening_bal', 'crdr_id', 'groupcode_id', 'is_visible', 'status_id', 
              'created_by', 'deleted_at',
    ];


    public function user()
    {
      return $this->hasOne(User::class);
    }

    public function crdr()
    {
      return $this->belongsTo('App\Crdr');
    }

    public function account_type()
    {
      return $this->belongsTo('App\AccountType');
    }

    public function groupcode()
    {
      return $this->belongsTo('App\Groupcode');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }

    public function ledgers()
    {
      return $this->hasMany('App\Ledger');
    }

    

}

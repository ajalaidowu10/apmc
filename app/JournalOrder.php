<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalOrder extends Model
{
  use SoftDeletes;
  protected $fillable = ['enter_date', 'total_cr_amount', 'total_dr_amount',  'created_by', 'status_id', 'deleted_at'];

  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($journal) {
        $journal->journal_order_items()->each(function ($journal_order_item)
        {
          $journal_order_item->delete();
        });
    });
  }   

  public function journal_order_items()
  {
    return $this->hasMany('App\JournalOrderItem');
  }
}

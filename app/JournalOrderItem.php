<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalOrderItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
                            'journal_order_id', 'acct_one_id', 'crdr_id', 
                            'amount', 'descp', 'del_record', 'amount', 'deleted_at',
                            'finyear_id', 'company_id',
                         ];

    public function journal_order()
    {
      return $this->belongsTo('App\JournalOrder');
    }

    public function acct_one()
    {
      return $this->belongsTo('App\Account', 'acct_one_id');
    }

    public function crdr()
    {
     return $this->belongsTo('App\Crdr');
    } 
}

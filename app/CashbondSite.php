<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashbondSite extends Model
{
    protected $table = 'cashbond_sites';

    protected $fillable = ['code', 'user_id', 'amount', 'description', 'status', 'transaction_date', 'accounted_approval'];

    //the owner / requester of the cashbond
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}

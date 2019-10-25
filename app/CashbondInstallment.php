<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashbondInstallment extends Model
{
    protected $table = 'cashbond_installments';

    protected $fillable = ['cashbond_id', 'amount', 'installment_schedule', 'status'];

    public function cashbond()
    {
    	return $this->belongsTo('App\Cashbond');
    }
    
}

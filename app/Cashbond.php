<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashbond extends Model
{
    protected $table = 'cashbonds';

    protected $fillable = [
        'code', 'user_id', 'amount', 'description', 'status', 
        'transaction_date', 'accounted_approval', 'remitter_bank_id', 
        'cut_from_salary', 'term', 'payment_status'
    ];

    //the owner / requester of the cashbond
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function remitter_bank()
    {
    	return $this->belongsTo('App\Cash', 'remitter_bank_id');
    }
    

    public function cashbond_installments()
    {
        return $this->hasMany('App\CashbondInstallment');
    }
}

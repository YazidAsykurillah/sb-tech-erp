<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAdministration extends Model
{
    protected $table = 'bank_administrations';

    protected $fillable = ['code', 'cash_id', 'refference_number', 'description', 'amount', 'accounted'];

    public function cash()
    {
    	return $this->belongsTo('App\Cash', 'cash_id');
    }
}

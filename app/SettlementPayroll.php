<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementPayroll extends Model
{
    protected $table = 'settlement_payrolls';

    protected $fillable = ['settlement_id', 'payroll_id'];

    public function settlement(){
    	return $this->belongsTo('App\Settlement');
    }

    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

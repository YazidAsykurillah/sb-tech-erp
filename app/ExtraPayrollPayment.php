<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraPayrollPayment extends Model
{
    protected $table = 'extra_payroll_payments';
    protected $fillable = [
    	'payroll_id', 'type', 'description', 'amount'
    ];

    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

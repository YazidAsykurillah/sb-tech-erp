<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyAllowance extends Model
{
    protected $table = 'competency_allowances';

    protected $filable = [
    	'payroll_id', 'amount'
    ];


    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

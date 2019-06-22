<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $fillable = ['period_id', 'user_id', 'thp_amount', 'is_printed'];

    public function period()
    {
    	return $this->belongsTo('App\Period');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function workshop_allowance(){
        return $this->hasOne('App\WorkshopAllowance');
    }

    public function competency_allowance()
    {
        return $this->hasOne('App\CompetencyAllowance');
    }

    public function extra_payroll_payment()
    {
        return $this->hasMany('App\ExtraPayrollPayment');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $fillable = ['period_id', 'user_id', 'thp_amount', 'is_printed', 'status'];

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

    public function incentive_weekday()
    {
        return $this->hasOne('App\IncentiveWeekDay');
    }
    public function incentive_weekend()
    {
        return $this->hasOne('App\IncentiveWeekEnd');
    }
    
    public function bpjs_kesehatan()
    {
        return $this->hasOne('App\BpjsKesehatan');
    }

    public function bpjs_ketenagakerjaan()
    {
        return $this->hasOne('App\BpjsKetenagakerjaan');
    }
}

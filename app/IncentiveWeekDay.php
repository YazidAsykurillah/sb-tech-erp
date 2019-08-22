<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncentiveWeekDay extends Model
{
    protected $table = 'incentive_week_days';

    protected $fillable = [
    	'payroll_id', 'amount', 'multiplier', 'total_amount'
    ];


    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

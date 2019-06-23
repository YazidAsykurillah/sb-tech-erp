<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncentiveWeekEnd extends Model
{
    protected $table = 'incentive_week_ends';

    protected $fillable = [
    	'payroll_id', 'amount', 'multiplier', 'total_amount'
    ];


    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

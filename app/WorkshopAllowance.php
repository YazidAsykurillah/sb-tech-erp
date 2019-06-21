<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopAllowance extends Model
{
    protected $table = 'workshop_allowances';
    
    protected $fillable = [
    	'payroll_id', 'amount', 'multiplier', 'total_amount'
    ];
}

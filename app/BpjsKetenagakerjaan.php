<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpjsKetenagakerjaan extends Model
{
    protected $table = 'bpjs_ketenagakerjaans';

    protected $fillable = ['payroll_id', 'amount'];

    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpjsKesehatan extends Model
{
    protected $table = 'bpjs_kesehatans';

    protected $fillable = ['payroll_id', 'amount'];

    public function payroll()
    {
    	return $this->belongsTo('App\Payroll');
    }
}

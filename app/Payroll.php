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

}

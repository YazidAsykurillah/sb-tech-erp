<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'periods';

    protected $fillable = ['code', 'the_year', 'the_month', 'start_date', 'end_date'];

    public function time_reports()
    {
    	return $this->hasMany('App\TimeReport');
    }

    public function ets()
    {
    	return $this->hasMany('App\Ets');
    }
}

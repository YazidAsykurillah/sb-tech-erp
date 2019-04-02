<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeReport extends Model
{
    protected $table = 'time_reports';

    protected $fillable = ['period_id', 'the_date', 'type'];

}

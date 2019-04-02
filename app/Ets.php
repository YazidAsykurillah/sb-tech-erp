<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ets extends Model
{
    protected $table = 'ets';

    protected $fillable = [
    	'user_id','period_id', 'the_date', 'start_time', 'end_time', 'description'
    ];

    public function period()
    {
    	return $this->belongsTo('App\Period');
    }
}

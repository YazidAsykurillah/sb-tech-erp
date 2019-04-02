<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLog extends Model
{
    protected $table = 'the_logs';

    protected $fillable = ['source', 'mode', 'refference_id', 'user_id', 'description'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}

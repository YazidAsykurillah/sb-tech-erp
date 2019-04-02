<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cashes';

    protected $fillable = ['type', 'name', 'account_number', 'description', 'amount', 'enabled'];


    public function transactions()
    {
    	return $this->hasMany('App\Cash');
    }

}

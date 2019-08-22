<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $table = 'allowances';

    protected $fillable = ['period_id', 'user_id', 'name'];

    public function allowance_items()
    {
    	return $this->hasMany('App\AllowanceItem');
    }
}

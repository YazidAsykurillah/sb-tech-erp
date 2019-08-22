<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';
    protected $fillable = ['user_id', 'name', 'account_number'];


    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}

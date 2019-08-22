<?php

namespace App;
use App\Role;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

	protected $fillable = ['slug', 'description'];
	
    public function roles(){

    	return $this->belongsToMany('App\Role');
    }
}

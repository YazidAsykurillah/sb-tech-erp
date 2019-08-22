<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SubCategory;

class Category extends Model
{
    protected $table = 'categories';

    protected $filable = ['name', 'description'];


    public function sub_categories()
    {
    	return $this->hasMany('App\SubCategory');
    }

}

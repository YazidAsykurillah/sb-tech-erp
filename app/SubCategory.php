<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Category;
class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = ['name', 'description', 'category_id'];

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }
}

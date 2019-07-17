<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
    	'code', 'name', 'initial_stock', 'stock', 'unit', 'price', 'brand', 'part_number', 'product_category_id'
    ];



    public function product_category()
    {
    	return $this->belongsTo('App\ProductCategory');
    }
    
}

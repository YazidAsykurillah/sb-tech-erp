<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $ftillable = [
    	'code', 'name', 'initial_stock', 'stock', 'unit', 'price', 'brand', 'part_number', 'product_category_id'
    ];
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';

    protected $fillable = ['code', 'name', 'price', 'asset_category_id', 'type', 'description'];

    public function asset_category()
    {
    	return $this->belongsTo('App\AssetCategory');
    }
}

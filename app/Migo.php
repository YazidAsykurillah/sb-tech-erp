<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Migo extends Model
{
    protected $table = 'migos';

    protected $fillable = [
    	'code', 'description', 'purchase_request_id', 'creator_id'
    ];

    public function purchase_request()
    {
    	return $this->belongsTo('App\PurchaseRequest');
    }

    public function creator()
    {
    	return $this->belongsTo('App\User', 'creator_id', 'id');
    }
    
}

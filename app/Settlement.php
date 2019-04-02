<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InternalRequest;

class Settlement extends Model
{
    protected $table = 'settlements';

    protected $fillable = ['code', 'internal_request_id', 'transaction_date', 'description', 'category_id', 'sub_category_id', 'amount', 'result', 'status', 'last_updater_id'];

    public function internal_request()
    {
    	return $this->belongsTo('App\InternalRequest', 'internal_request_id');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function sub_category()
    {
    	return $this->belongsTo('App\SubCategory', 'sub_category_id');
    }

    public function last_updater()
    {
    	return $this->belongsTo('App\User', 'last_updater_id');
    }


    public function remitter_bank()
    {
        return $this->belongsTo('App\Cash', 'remitter_bank_id');
    }
    
}

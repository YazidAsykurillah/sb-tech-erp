<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationVendor extends Model
{
    protected $table = 'quotation_vendors';

    protected $fillable = [
    	'code', 'purchase_request_id', 'vendor_id', 'amount', 'description', 'status',
    	'received_date', 'purchase_order_vendored', 'user_id'
    ];

 	public function vendor()
 	{
 		return $this->belongsTo('App\Vendor');
 	}

 	public function purchase_request()
 	{
 		return $this->hasOne('App\PurchaseRequest', 'quotation_vendor_id');
 	}
 	/*public function purchase_request()
 	{
 		return $this->belongsTo('App\PurchaseRequest', 'purchase_request_id');
 	}*/

 	public function user()
 	{
 		return $this->belongsTo('App\User');
 	}
}

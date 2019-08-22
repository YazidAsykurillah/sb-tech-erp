<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PurchaseOrderCustomer;
use App\Customer;
use App\QuotationCustomer;
class PurchaseOrderCustomer extends Model
{
    protected $table = 'purchase_order_customers';

    protected $fillable = ['code', 'customer_id', 'desription', 'amount', 'quotation_customer_id', 'received_date', 'status'];

    public function customer()
    {
    	return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function project()
    {
    	return $this->hasOne('App\Project');
    }

    public function quotation_customer()
    {
        return $this->belongsTo('App\QuotationCustomer', 'quotation_customer_id');
    }
    
}

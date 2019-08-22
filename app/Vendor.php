<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseOrderVendor;
use App\InvoiceVendor;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $fillable = ['name', 'product_name', 'bank_account'];

    public function purchase_order_vendor()
    {
    	return $this->hasMany('App\PurchaseOrderVendor');
    }

    public function invoice_vendors()
    {
    	return $this->hasManyThrough('App\InvoiceVendor', 'App\PurchaseOrderVendor');
    }
}

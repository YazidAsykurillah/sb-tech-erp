<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseOrderCustomer;
use App\Project;
use App\InvoiceCustomer;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = ['name', 'address', 'contact_number'];


    public function purchase_order_customers()
    {
    	return $this->hasMany('App\PurchaseOrderCustomer');
    }


    public function projects()
    {
    	return $this->hasManyThrough('App\Project', 'App\PurchaseOrderCustomer');
    }

    

}

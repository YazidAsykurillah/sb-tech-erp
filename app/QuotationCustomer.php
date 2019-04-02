<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\User;

class QuotationCustomer extends Model
{
	protected $table = 'quotation_customers';

   	protected $fillable = ['code', 'customer_id','sales_id', 'amount', 'description', 'submitted_date', 'status', 'file'];


    public function customer()
    {
    	return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function sales()
    {
    	return $this->belongsTo('App\User', 'sales_id');
    }

    public function po_customer()
    {
        return $this->hasOne('App\PurchaseOrderCustomer');
    }
    
}

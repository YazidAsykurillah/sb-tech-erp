<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceCustomerTax extends Model
{
    protected $table = 'invoice_customer_taxes';

    protected $fillable = ['invoice_customer_id', 'source', 'percentage', 'amount', 'status', 'approval', 'tax_number', 'cash_id'];

    public function invoice_customer()
    {
    	return $this->belongsTo('App\InvoiceCustomer');
    }

    public function cash()
    {
    	return $this->belongsTo('App\Cash');
    }
}

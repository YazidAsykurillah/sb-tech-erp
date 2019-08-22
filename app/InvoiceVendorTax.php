<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceVendorTax extends Model
{
    protected $table = 'invoice_vendor_taxes';

    protected $fillable = ['invoice_vendor_id', 'source', 'percentage', 'amount', 'status', 'approval', 'tax_number', 'cash_id'];

    public function invoice_vendor()
    {
    	return $this->belongsTo('App\InvoiceVendor');
    }

    public function cash()
    {
    	return $this->belongsTo('App\Cash');
    }
}

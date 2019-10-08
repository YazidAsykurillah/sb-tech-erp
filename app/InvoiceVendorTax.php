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

    public static function countTotalByYearMonth($yearmonth)
    {
        $invoice_vendor_taxes = InvoiceVendorTax::whereHas('invoice_vendor', function($query) use ($yearmonth){
            $query->where('invoice_vendors.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_vendor_taxes.source', '=', "vat");
            $query->where('invoice_vendor_taxes.tax_number', 'NOT LIKE', "0000%");
        })
        ->sum('amount');
        return $invoice_vendor_taxes;
    }
}

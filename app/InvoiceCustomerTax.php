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


    public static function countTotalByYearMonth($yearmonth)
    {
        $invoice_customer_taxes = InvoiceCustomerTax::whereHas('invoice_customer', function($query) use ($yearmonth){
            $query->where('invoice_customers.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_customer_taxes.source', '=', "vat");
            $query->where('invoice_customer_taxes.tax_number', 'NOT LIKE', "0000%");
        })
        ->sum('amount');
        return $invoice_customer_taxes;
    }
}

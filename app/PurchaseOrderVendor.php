<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Vendor;
use App\PurchaseRequest;

use App\InvoiceVendor;

class PurchaseOrderVendor extends Model
{
    protected $table = 'purchase_order_vendors';

    protected $fillable = [
        'vendor_id','code', 'date', 'purchase_request_id', 'description', 'amount',
        'sub_amount', 'vat', 'wht', 'discount', 'after_discount',
        'quotation_vendor_id', 'terms'
    ];

    protected $appends = [
        'invoice_vendor_due', 'UnInvoicedAmount', 'vat_value'
    ];


    public function vendor()
    {
    	return $this->belongsTo('App\Vendor', 'vendor_id');
    }

    public function purchase_request()
    {
    	return $this->belongsTo('App\PurchaseRequest', 'purchase_request_id');
    }

    public function invoice_vendor()
    {
        return $this->hasMany('App\InvoiceVendor');
    }

    public function quotation_vendor()
    {
        return $this->belongsTo('App\QuotationVendor', 'quotation_vendor_id');
    }

    //paid invoice vendor
    public function paid_invoice_vendor()
    {
        $result = 0;
        $paid_invoice_vendor = 0;
        if($this->invoice_vendor->count()){

            //$result = $this->invoice_vendor()->where('status','=','paid')->sum('amount');
            $result = $this->invoice_vendor;
            foreach($result as $res){
                if($res->status == 'paid'){
                    if($res->type == 'billing'){
                        $paid_invoice_vendor+=$res->bill_amount;    
                    }else{
                        $paid_invoice_vendor+=$res->amount;
                    }
                    
                }
            }
            
        }
        return floatval($paid_invoice_vendor);
    }

    //pending invoice vendor
    public function pending_invoice_vendor()
    {
        $result = 0;
        if($this->invoice_vendor->count()){
            $result = $this->invoice_vendor()->where('status','=','pending')->sum('amount');
        }
        return floatval($result);
    }


    //Get invoice vendor due attribute
    public function getInvoiceVendorDueAttribute()
    {
        $result = 0;
        $after_discount = $this->amount;
        $paid_invoice_vendor = $this->paid_invoice_vendor();
        $result = $after_discount - $paid_invoice_vendor;
        
        return $result;
    }


    public function getUnInvoicedAmountAttribute()
    {
        $po_amount = $this->amount;
        $invoiced_amount = 0;
        $invoice_vendors = $this->invoice_vendor;
        if($invoice_vendors->count()){
            foreach($invoice_vendors as $inv){
                if($inv->type == 'billing'){
                    $invoiced_amount+=$inv->bill_amount;    
                }else{
                    $invoiced_amount+=$inv->amount;
                }
            }
        }
        $un_invoiced_amount = $po_amount - $invoiced_amount;
        return $un_invoiced_amount;
    }


    public function getVatValueAttribute()
    {
        $result = 0;
        $vat = $this->vat;
        $after_discount = $this->after_discount;
        $result = $this->vat / 100 * $after_discount;
        return $result;

    }
}

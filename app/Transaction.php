<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InternalRequest;
use App\Settlement;
use App\InvoiceVendor;
use App\InvoiceCustomer;
use App\Cashbond;
use App\AccountingExpense;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['cash_id', 'refference', 'refference_id', 'refference_number', 'type', 'amount', 'notes', 'transaction_date', 'accounting_expense_id'];

    protected $appends = ['member_name'];

    public function cash()
    {
    	return $this->belongsTo('App\Cash');
    }


    public function getMemberNameAttribute()
    {
    	if($this->refference == 'internal_request'){
    		$internal_request = InternalRequest::find($this->refference_id);
    		return $internal_request->requester->name;
    	}
    	else if($this->refference == 'settlement'){
    		$settlement = Settlement::find($this->refference_id);
    		return $settlement->internal_request->requester->name;
    	}
        else if($this->refference == 'cashbond'){
            $cashbond = Cashbond::find($this->refference_id);
            if($cashbond){
                if($cashbond->user){
                    return $cashbond->user->name;    
                }
                else{
                    return NULL;
                }
                
            }
            
        }
        else if($this->refference == 'invoice_vendor'){
            $invoice_vendor = InvoiceVendor::find($this->refference_id);
            if($invoice_vendor){
                return $invoice_vendor->purchase_order_vendor->vendor ? $invoice_vendor->purchase_order_vendor->vendor->name : "" ;
            }
            
        }
        else if($this->refference == 'invoice_customer'){
            $invoice_customer = InvoiceCustomer::find($this->refference_id);
            if($invoice_customer){
                if($invoice_customer->project){
                    if($invoice_customer->project->purchase_order_customer){
                        return $invoice_customer->project->purchase_order_customer->customer ? $invoice_customer->project->purchase_order_customer->customer->name : '';
                    }
                    return null;
                }
                return NULL;
            }
            return NULL;
        }
    	else{
    		return "";
    	}

    }


    public function accounting_expense()
    {
        return $this->belongsTo('App\AccountingExpense');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_requests';

    protected $fillable = ['code', 'project_id', 'description', 'amount', 'quotation_vendor_id'];


    public function project()
    {
    	return $this->belongsTo('App\Project', 'project_id');
    }
    
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function quotation_vendor()
    {
    	return $this->belongsTo('App\QuotationVendor');
    }

    public function purchase_order_vendor()
    {
        return $this->hasOne('App\PurchaseOrderVendor', 'purchase_request_id');
    }

    public function vat_value()
    {
        //number_format($purchase_request->vat / 100 * $purchase_request->after_discount)
        $vat_value = 0;
        if($this->discount != NULL && $this->after_discount != NULL){
            $vat_value = $this->vat/100 * $this->after_discount;
        }else{
            $vat_value = $this->vat/100 * $this->sub_amount;
        }
        return $vat_value;
    }
    
}

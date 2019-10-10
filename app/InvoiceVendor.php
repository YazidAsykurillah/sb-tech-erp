<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InvoiceVendor;
use App\Project;
use App\PurchaseOrderVendor;

class InvoiceVendor extends Model
{
    protected $table = 'invoice_vendors';

    protected $fillable = [
        'code', 'tax_number', 'amount', 'project_id', 'purchase_order_vendor_id',
        'due_date', 'status', 'received_date', 'cash_id', 'accounted_approval', 'tax_date',
        'bill_amount'
    ];

    public function project()
    {
    	return $this->belongsTo('App\Project', 'project_id');
    }

    public function purchase_order_vendor()
    {
    	return $this->belongsTo('App\PurchaseOrderVendor', 'purchase_order_vendor_id');
    }

    public function remitter_bank()
    {
        return $this->belongsTo('App\Cash', 'cash_id');
    }

    public static function countTotalByYearMonth($yearmonth)
    {
        $result = InvoiceVendor::where('due_date', 'LIKE', "%$yearmonth%")->sum('amount');
        return $result;
    }
}

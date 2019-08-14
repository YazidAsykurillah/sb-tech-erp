<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory;
use App\PurchaseOrderVendor;
class StoreInvoiceVendorRequest extends Request
{
    public function __construct(Factory $factory)
    {

        $name = 'is_max_amount'; // a name for our custom rule, to be referenced in `rules` below
        
        $test = function ($_x, $value, $_y) {
            $purchase_order = PurchaseOrderVendor::findOrFail(\Request::get('purchase_order_vendor_id'));
            //$max = floatval(\Request::get('total_invoice_due'));
            $cleared_max = $purchase_order->invoice_vendor_due+0.1;
            $cleared_value = floatval(preg_replace('#[^0-9.]#', '', $value));
            //echo $cleared_value;exit();
            return $cleared_value < $cleared_max;
        };
        $errorMessage = "Can not more than invoice vendor due";

        $factory->extend($name, $test, $errorMessage);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'code'=>'required|unique:invoice_vendors,code',
            'tax_number'=>'required',
            'project_id'=>'required|integer',
            'purchase_order_vendor_id'=>'required|integer',
            'type'=>'required',
            'amount'=>'required|is_max_amount',
            'due_date'=>'required',
            'received_date'=>'required',
            'tax_date'=>'required_with:tax_number'
        ];
    }
}

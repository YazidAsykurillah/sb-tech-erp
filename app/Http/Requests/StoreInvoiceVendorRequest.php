<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreInvoiceVendorRequest extends Request
{
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
            'amount'=>'required',
            'due_date'=>'required',
            'received_date'=>'required',
            'tax_date'=>'required_with:tax_number'
        ];
    }
}

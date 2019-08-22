<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreQuotationVendorFromPurchaseRequest extends Request
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
            'the_vendor_id'=>'required|integer|exists:vendors,id',
            'quotation_vendor_code'=>'required|unique:quotation_vendors,code',
            'quotation_vendor_description'=>'required',
            'quotation_vendor_amount'=>'required',
            'quotation_vendor_received_date'=>'required'
        ];
    }
}

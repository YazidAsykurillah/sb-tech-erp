<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePurchaseOrderVendorRequest extends Request
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
            'code'=>'required|unique:purchase_order_vendors,code,'.$this->segment(2),
            'purchase_request_id'=>'required|integer',
            //'quotation_vendor_id'=>'required|integer|exists:quotation_vendors,id|unique:purchase_order_vendors,quotation_vendor_id,'.$this->segment(2),
            'description'=>'required',
            //'amount'=>'required'
        ];
    }
}

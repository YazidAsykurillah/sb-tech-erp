<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreQuotationVendorRequest extends Request
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
            'code'=>'required|unique:quotation_vendors,code',
            //'purchase_request_id'=>'required|integer|exists:purchase_requests,id',
            'vendor_id'=>'required|integer|exists:vendors,id',
            'amount'=>'required',
            'description'=>'required',
            'received_date'=>'required'
        ];
    }
}

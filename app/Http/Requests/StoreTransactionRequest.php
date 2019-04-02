<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreTransactionRequest extends Request
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
            'cash_id'=>'required|exists:cashes,id',
            'refference'=>'required',
            'internal_request_id'=>'required_if:refference,internal_request',
            'settlement_id'=>'required_if:refference,settlement',
            'cashbond_id'=>'required_if:refference,cashbond',
            'invoice_customer_id'=>'required_if:refference,invoice_customer',
            'invoice_vendor_id'=>'required_if:refference,invoice_vendor',
            'bank_administration_id'=>'required_if:refference,bank_administration',
            'amount'=>'required',
            'type'=>'required'
        ];
    }
}

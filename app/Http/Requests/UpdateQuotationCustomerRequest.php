<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateQuotationCustomerRequest extends Request
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
            'code'=>'required|unique:quotation_customers,code,'.$this->segment(2),
            'customer_id'=>'required|integer',
            'sales_id'=>'required|integer',
            'amount'=>'required',
            'description'=>'required'
        ];
    }
}

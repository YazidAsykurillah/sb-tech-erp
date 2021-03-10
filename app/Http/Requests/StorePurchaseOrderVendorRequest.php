<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePurchaseOrderVendorRequest extends Request
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
        $rules = [
            'code'=>'required|unique:purchase_order_vendors,code',
            'purchase_request_id'=>'required|integer',
            //'quotation_vendor_id'=>'required|integer|exists:quotation_vendors,id|unique:purchase_order_vendors,quotation_vendor_id',
            'description'=>'required',
            /*'vat'=>'required',
            'discount'=>'required',
            'after_discount'=>'required',
            'amount'=>'required'*/
        ];
        /*foreach($this->request->get('item') as $key => $val){
            $rules['item.'.$key] = 'required';
        }*/
        return $rules;
    }
}

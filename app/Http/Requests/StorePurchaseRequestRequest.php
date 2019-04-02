<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePurchaseRequestRequest extends Request
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
        $rules =  [
            'project_id'=>'required|integer|exists:projects,id',
            'quotation_vendor_id'=>'exists:quotation_vendors,id',
            'description'=>'required',
            'amount'=>'required'
        ];
        
        foreach($this->request->get('item') as $key => $val){
            $rules['item.'.$key] = 'required';
        }

        return $rules;
    }
}

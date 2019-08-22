<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreDeliveryOrderRequest extends Request
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
            'project_id'=>'required|integer|exists:projects,id',
            'sender_id'=>'required|integer|exists:users,id',
        ];
        
        $item = $this->input('item');
        foreach ($item as $index => $item) {
            $rules["item.{$index}"] = 'required';
        }
        foreach($this->input('quantity') as $key=>$val){
            $rules["quantity.{$key}"] = 'required';
        }

        //print_r($rules);exit();

        return $rules;
        
        
    }
}

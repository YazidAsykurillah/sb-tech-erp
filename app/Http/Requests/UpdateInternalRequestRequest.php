<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateInternalRequestRequest extends Request
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
            'description'=>'required',
            'type'=>'required',
            'amount'=>'required',
            //'vendor_id'=>'required|integer|exists:vendors,id',
            /*'remitter_bank_id'=>'required|integer|exists:cashes,id',
            'beneficiary_bank_id'=>'required|integer|exists:bank_accounts,id',*/
            'requester_id'=>'required|exists:users,id'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreInternalRequestRequest extends Request
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
            'amount'=>'required',/*
            'remitter_bank_id'=>'required|integer|exists:cashes,id',
            'beneficiary_bank_id'=>'required|integer|exists:bank_accounts,id',*/
            'project_id'=>'required|exists:projects,id',
            //'vendor_id'=>'required_if:type,material|exists:vendors,id',
            'type'=>'required',
            'requester_id'=>'required|exists:users,id'
        ];
    }
}

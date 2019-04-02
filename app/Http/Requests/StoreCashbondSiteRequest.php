<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCashbondSiteRequest extends Request
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
            'user_id'=>'required|integer|exists:users,id',
            'amount'=>'required',
            'description'=>'required',
            'cash_id'=>'required|integer|exists:cashes,id',
            'transaction_date'=>'required',
        ];
    }
}

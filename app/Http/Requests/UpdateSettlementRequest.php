<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateSettlementRequest extends Request
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
            'internal_request_id'=>'required|integer|exists:internal_requests,id',
            'transaction_date'=>'required',
            'description'=>'required',
            'amount'=>'required',
        ];
    }
}

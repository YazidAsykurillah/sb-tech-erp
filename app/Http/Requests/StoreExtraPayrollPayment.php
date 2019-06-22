<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreExtraPayrollPayment extends Request
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
            'payroll_id'=>'required|exists:payrolls,id',
            'epp_description'=>'required',
            'epp_amount'=>'required',
            'epp_type'=>'required',
        ];
    }
}

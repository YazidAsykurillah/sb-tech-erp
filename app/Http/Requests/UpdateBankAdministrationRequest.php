<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateBankAdministrationRequest extends Request
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
            'refference_number'=>'required|unique:bank_administrations,refference_number,'.$this->segment(2),
            'description'=>'required',
            'amount'=>'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
            'name'=>'required',
            'number_id' => 'required|unique:users,nik,'.$this->segment(2).'',
            'role_id'=>'required|integer',
            'position'=>'required',
            'email'=>'required|email|unique:users,email,'.$this->segment(2).'',
            'salary'=>'required'
        ];
    }
}

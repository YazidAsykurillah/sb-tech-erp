<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreTaskAssigneeRequest extends Request
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
            'task_id'=>'required|integer|exists:tasks,id',
            'user_id'=>'required|integer|exists:users,id',
        ];
    }
}

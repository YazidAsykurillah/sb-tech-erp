<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreSubCategoryRequest extends Request
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
            'category_id'=>'required|integer|exists:categories,id',
            'subCategoryName'=>'required|unique:sub_categories,name',
            'subCategoryDescription'=>'required',
        ];
    }
}

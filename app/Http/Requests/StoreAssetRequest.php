<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreAssetRequest extends Request
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
            'asset_category_id'=>'required|integer|exists:asset_categories,id',
            'name'=>'required',
            'price'=>'required',
        ];
    }
}

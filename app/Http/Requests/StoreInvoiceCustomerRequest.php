<?php

namespace App\Http\Requests;


use App\Http\Requests\Request;

use Illuminate\Validation\Factory;

use App\Project;

class StoreInvoiceCustomerRequest extends Request
{

    public function __construct(Factory $factory)
    {
        $name = 'is_max_amount'; // a name for our custom rule, to be referenced in `rules` below
        
        $test = function ($_x, $value, $_y) {
            $max = floatval(\Request::get('total_invoice_due'));
            //echo $max+floatval(0.01);exit();
            $cleared_max = $max+floatval(0.01);
            $cleared_value = floatval(preg_replace('#[^0-9.]#', '', $value));
            //echo $cleared_value;exit();
            return $cleared_value < $cleared_max;
        };
        $errorMessage = 'Can not more than total invoice due';

        $factory->extend($name, $test, $errorMessage);
    }
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
         
        $rules =  [
            'tax_number'=>'required',
            'project_id'=>'required|integer',
            'amount'=>'required|is_max_amount',
            'due_date'=>'required',
            'posting_date'=>'required',
        ];

        foreach($this->request->get('item') as $key => $val){
            $rules['item.'.$key] = 'required';
        }

        return $rules;
            
       

    }
}

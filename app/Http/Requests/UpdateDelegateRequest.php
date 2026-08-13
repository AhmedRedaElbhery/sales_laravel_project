<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDelegateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'active'=> 'required',

            'commission_type' => 'required',
            'percent_Wholesale_commission' => 'required|numeric|max:10',
            'percent_half_wholesale_commission' => 'required|numeric|max:10',
            'percent_retail_commission' => 'required|numeric|max:10',
            'percent_collect_commission' => 'required|numeric|max:10',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'ادخل اسم الحساب',
            'active.required'=> 'اختر الحاله',

            'commission_type.required' => 'اختر الحاله',

            'percent_Wholesale_commission.required' => 'ادخل القيمه ',
            'percent_half_wholesale_commission.required' => 'ادخل القيمه ',
            'percent_retail_commission.required' => 'ادخل القيمه',
            'percent_collect_commission.required' => 'ادخل القيمه',

            'percent_Wholesale_commission.max' => 'ادخل قيمه صحيحه لا تتعدى 10 ',
            'percent_half_wholesale_commission.max' => 'ادخل قيمه صحيحه لا تتعدى 10',
            'percent_retail_commission.max' => 'ادخل قيمه صحيحه لا تتعدى 10',
            'percent_collect_commission.max' => 'ادخل قيمه صحيحه لا تتعدى 10',
        ];
    }
}
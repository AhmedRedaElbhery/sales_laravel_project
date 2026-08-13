<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelegateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'active' => 'required',
            'start_balance_status' => 'required',
            'start_balance' => 'required|numeric',
            'commission_type' => 'required',
            'percent_Wholesale_commission' => 'required|numeric|max:10',
            'percent_half_wholesale_commission' => 'required|numeric|max:10',
            'percent_retail_commission' => 'required|numeric|max:10',
            'percent_collect_commission' => 'required|numeric|max:10',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'ادخل اسم الحساب',
            'active.required' => 'اختر الحاله',
            'start_balance_status.required' => 'ادخل حاله الحساب',
            'start_balance.required' => 'ادخل قيمه الحساب الاوليه',
            'start_balance.numeric' => 'ادخل قيمه صحيحه',

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
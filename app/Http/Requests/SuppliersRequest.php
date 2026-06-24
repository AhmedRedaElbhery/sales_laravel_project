<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuppliersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'active'=> 'required',
            'category_id'=> 'required',
            'start_balance_status'=> 'required',
            'start_balance'=> 'required|numeric',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'ادخل اسم الحساب',
            'active.required'=> 'اختر الحاله',
            'category_id.required'=> 'اختر الفئه',
            'start_balance_status.required'=> 'ادخل حاله الحساب',
            'start_balance.required'=> 'ادخل قيمه الحساب الاوليه',
            'start_balance.numeric'=> 'ادخل قيمه صحيحه',
        ];
    }
}
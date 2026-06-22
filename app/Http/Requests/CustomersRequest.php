<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
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
            'start_balance_status'=> 'required',
            'start_balance'=> 'required|numeric',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'ادخل اسم الحساب',
            'active.required'=> 'اختر الحاله',
            'start_balance_status.required'=> 'ادخل حاله الحساب',
            'start_balance.required'=> 'ادخل قيمه الحساب الاوليه',
            'start_balance.numeric'=> 'ادخل قيمه صحيحه',
        ];
    }
}
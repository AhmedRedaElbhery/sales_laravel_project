<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        ];
    }
    public function messages(){
        return[
            'name.required'=>'ادخل اسم الحساب',
            'active.required'=> 'اختر الحاله',
        ];
    }
}
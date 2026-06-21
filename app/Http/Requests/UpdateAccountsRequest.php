<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountsRequest extends FormRequest
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
            'account_type'=> 'required',
            'is_archived'=> 'required',
            'parent_account_number'=> 'required',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'ادخل اسم الحساب',
            'account_type.required'=> 'اختر نوع الحساب',
            'is_archived.required'=> 'اختر الحاله',
            'parent_account_number.required'=> 'ادخل نوع الحساب',
        ];
    }
}
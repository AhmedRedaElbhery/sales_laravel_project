<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPanelSettingRequest extends FormRequest
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
            'system_name'=>'required',
            'address'=> 'required',
            'phone'=> 'required',
            'customer_parent_account_number'=> 'required',
        ];
    }
    public function messages(){
        return[
            'system_name.required'=>'اسم المستخدم مطلوب',
            'address.required'=>' العنوان مطلوب',
            'phone.required'=>' الهاتف مطلوب',
            'customer_parent_account_number.required'=>'  اختر الحساب',
        ];
    }
}
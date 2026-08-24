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
            'supplier_parent_account_number'=> 'required',
            'delegate_parent_account_number'=> 'required',
            'employess_parent_account_number'=> 'required',

        ];
    }
    public function messages(){
        return[
            'system_name.required'=>__('validation.system_name_required'),
            'address.required'=>__('validation.address_required'),
            'phone.required'=>__('validation.phone_required'),
            'supplier_parent_account_number.required'=>__('validation.supplier_parent_account_number_required'),
            'customer_parent_account_number.required'=>__('validation.customer_parent_account_number_required'),
            'delegate_parent_account_number.required'=>__('validation.delegate_parent_account_number_required'),
            'employess_parent_account_number.required'=>__('validation.employess_parent_account_number_required'),
        ];
    }
}
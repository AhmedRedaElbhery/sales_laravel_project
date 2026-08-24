<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
            'name'=>'required|unique:accounts,name',
            'account_type'=> 'required',
            'is_archived'=> 'required',
            'parent_account_number'=> 'required',
            'start_balance_status'=> 'required',
            'start_balance'=> 'required|numeric',
        ];
    }
    public function messages(){
        return[
            'name.required'=> __('validation.name_required'),
            'name.unique'=> __('validation.name_unique'),
            'account_type.required'=> __('validation.account_type_required'),
            'is_archived.required'=>__('validation.is_archived_required'),
            'parent_account_number.required'=>__('validation.parent_account_number_required'),
            'start_balance_status.required'=> __('validation.start_balance_status_required'),
            'start_balance.required'=> __('validation.start_balance_required'),
            'start_balance.numeric'=>__('validation.start_balance_numeric'),
        ];
    }
}
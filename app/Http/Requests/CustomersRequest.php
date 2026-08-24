<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('customers', 'name')->ignore($this->route('customer')),
            ],
            'active' => 'required',
            'start_balance_status' => 'required',
            'start_balance' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.unique' => __('validation.name_unique'),
            'active.required' => __('validation.active_required'),
            'start_balance_status.required' => __('validation.start_balance_status_required'),
            'start_balance.required' => __('validation.start_balance_required'),
            'start_balance.numeric' => __('validation.start_balance_numeric'),
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.unique' => __('validation.name_unique'),
            'active.required' => __('validation.active_required'),
        ];
    }
}
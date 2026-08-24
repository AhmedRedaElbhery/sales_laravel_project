<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoresRequest extends FormRequest
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
            'name' => [
            'required',
            Rule::unique('stores', 'name')
                ->where('com_code', auth()->user()->com_code)
                ->ignore($this->route('id')),
        ],
            'address' => 'required',
            'phone' => [
                'required',
                'numeric',
                Rule::unique('stores', 'phone')->ignore($this->id),
            ],
            'active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' =>__('validation.name_required'),
            'name.unique' =>__('validation.name_unique'),
            'address.required' => __('validation.address_required'),
            'phone.required' =>__('validation.phone_required'),
            'phone.numeric' => __('validation.phone_numeric'),
            'phone.unique' =>__('validation.phone_unique'),
            'active.required' =>__('validation.active_required'),
        ];
    }
}
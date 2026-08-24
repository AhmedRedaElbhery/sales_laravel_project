<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneralReturnOrdersRequest extends FormRequest
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
            'supplier_code' => [
                'required',
                Rule::exists('suppliers', 'supplier_code')
                    ->where('com_code', session('com_code')),
            ],
            'pill_type' => 'required',
            'store' => 'required',
            'order_date' => 'required',
        ];
    }

    public function messages(){
        return [
            'supplier_code.required' =>__('validation.supplier_code_required'),
            'supplier_code.exists' => __('validation.supplier_code_exists'),
            'pill_type.required' =>__('validation.pill_type_required'),
            'store.required' => __('validation.store_required'),
            'order_date.required' => __('validation.order_date_required'),
        ];
    }
}
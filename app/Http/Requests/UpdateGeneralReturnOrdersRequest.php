<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralReturnOrdersRequest extends FormRequest
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
            'supplier_code' => 'required',
            'pill_type' => 'required',
            'order_date' => 'required',
        ];
    }

    public function messages(){
        return [
            'supplier_code.required' => __('validation.name_required'),
            'pill_type.required' =>__('validation.pill_type_required'),
            'order_date.required' => __('validation.order_date_required'),
        ];
    }
}
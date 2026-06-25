<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierOrderRequest extends FormRequest
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
            'supplier_code.required' => 'اختر حساب المورد',
            'pill_type.required' => 'اختر نوع الفاتوره',
            'order_date.required' => 'اختر التاريخ',
        ];
    }
}
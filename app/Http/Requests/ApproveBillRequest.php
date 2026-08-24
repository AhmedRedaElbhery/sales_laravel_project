<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveBillRequest extends FormRequest
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
            'tax_percent'=>'required|numeric|between:0,100',
            'discount_percent'=>'required|numeric|between:0,100',
            'what_paid'=>'required|numeric',
        ];
    }
    public function messages(){
        return[
            'tax_percent.required'=>__('validation.tax_percent_required'),
            'discount_percent.required'=>__('validation.discount_percent_required'),
            'what_paid.required'=>__('validation.what_paid_required'),

            'tax_percent.numeric'=>__('validation.tax_percent_numeric'),
            'discount_percent.numeric'=>__('validation.discount_percent_numeric'),
            'what_paid.numeric'=>__('validation.what_paid_numeric'),

            'tax_percent.between'=>__('validation.tax_percent_between'),
            'discount_percent.between'=>__('validation.discount_percent_between'),
        ];
    }
}
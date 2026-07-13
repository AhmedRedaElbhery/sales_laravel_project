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
            'tax_percent.required'=>'ادخل نسبه الضريبه ',
            'discount_percent.required'=>'ادخل نسبه الخصم ',
            'what_paid.required'=>'ادخل المبلغ المدفوع ',

            'tax_percent.numeric'=>'ادخل رقم صحيح ',
            'discount_percent.numeric'=>'ادخل رقم صحيح ',
            'what_paid.numeric'=>'ادخل رقم صحيح ',

            'tax_percent.between'=>'ادخل رقم صحيح ',
            'discount_percent.between'=>'ادخل رقم صحيح ',
        ];
    }
}
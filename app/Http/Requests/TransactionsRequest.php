<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
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
            'account_number'=>'required',
            'date'=> 'required',
            'money'=> 'required',
            'treasuries_balance'=> 'required',
            'treasuries_id'=> 'required|numeric',
            'byan'=> 'required|numeric',
            'move_type'=> 'required',

        ];
    }
    public function messages(){
        return[
            'account_number.required'=>'اختر الحساب',
            'move_type.required'=>'اختر نوع الحركه',
            'date.required'=> 'ادخل التاريخ',
            'money.required'=> 'ادخل المبلغ',
            'treasuries_balance.required'=> 'ادخل المبلغ الخزنه',
            'treasuries_id.required'=> 'ادخل الخزنه',
            'byan.numeric'=> 'ادخل بيان لهذه العمليه',
        ];
    }
}
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
            'money' => 'required|numeric|gt:0',
            'treasuries_balance'=> 'required|numeric',
            'treasuries_id'=> 'required',
            'byan'=> 'required',
            'move_type'=> 'required',

        ];
    }
    public function messages(){
        return[
            'account_number.required'=>'اختر الحساب',
            'move_type.required'=>'اختر نوع الحركه',
            'date.required'=> 'ادخل التاريخ',
            'money.required'=> 'ادخل المبلغ',
            'money.numeric'=> 'ادخل رقم المبلغ صحيح',
            'money.gt'=> 'ادخل رقم المبلغ صحيح اكبر من 0',
            'money.treasuries_balance'=> 'ادخل رقم المبلغ صحيح',
            'treasuries_balance.required'=> 'ادخل المبلغ الخزنه',
            'treasuries_id.required'=> 'ادخل الخزنه',
            'byan.required'=> 'ادخل بيان لهذه العمليه',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
{
    /**
     * Determine if the username_required is authorized to make this request.
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
            'account_number.required'=>__('validation.account_number_required'),
            'move_type.required'=>__('validation.move_type_required'),
            'date.required'=> __('validation.date_required'),
            'money.required'=> __('validation.money_required'),
            'money.numeric'=> __('validation.money_numeric'),
            'money.gt'=> __('validation.money_gt'),
            'money.treasuries_balance'=> __('validation.money_treasuries_balance'),
            'treasuries_balance.required'=> __('validation.treasuries_balance_required'),
            'treasuries_id.required'=>__('validation.treasuries_id_required'),
            'byan.required'=> __('validation.byan_required'),
        ];
    }
}
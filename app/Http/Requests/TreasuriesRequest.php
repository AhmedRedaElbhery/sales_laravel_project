<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesRequest extends FormRequest
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
            'name'=>'required',
            'is_master'=>'required',
            'last_isal_exchange'=>'required|integer|min:0',
            'last_isal_collect'=>'required|integer|min:0',
            'active'=>'required',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'الاسم مطلوب',
            'is_master.required'=>'  يجب اختيار النوع',
            'last_isal_exchange.required'=>'  ادخل رقم صحيح',
            'last_isal_collect.required'=>'  ادخل رقم صحيح',
            'active.required'=>'  يجب اختيار النوع'
        ];
    }
}
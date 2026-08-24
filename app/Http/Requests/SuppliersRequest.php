<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuppliersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => [
            'required',
            Rule::unique('suppliers', 'name')
                ->where('com_code', auth()->user()->com_code)
                ->ignore($this->route('id')),
        ],
            'active'=> 'required',
            'category_id'=> 'required',
            'start_balance_status'=> 'required',
            'start_balance'=> 'required|numeric',
        ];
    }
    public function messages(){
        return[
            'name.required'=>__('validation.name_required'),
            'name.unique'=>__('validation.name_unique'),
            'active.required'=> __('validation.active_required'),
            'category_id.required'=> __('validation.category_id_required'),
            'start_balance_status.required'=>__('validation.start_balance_status_required'),
            'start_balance.required'=> __('validation.start_balance_required'),
            'start_balance.numeric'=> __('validation.start_balance_numeric'),
        ];
    }
}
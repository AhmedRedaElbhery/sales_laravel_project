<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
            'required',
            Rule::unique('treasuries', 'name')
                ->where('com_code', auth()->user()->com_code)
                ->ignore($this->route('id')),
        ],

            'is_master'=>'required',
            'last_isal_exchange'=>'required|integer|min:0',
            'last_isal_collect'=>'required|integer|min:0',
            'active'=>'required',
        ];
    }
    public function messages(){
        return[
            'name.required'=>__('validation.name_required'),
            'name.unique'=>__('validation.name_unique'),
            'is_master.required'=>__('validation.is_master_required'),
            'last_isal_exchange.required'=>__('validation.last_isal_exchange_required'),
            'last_isal_collect.required'=>__('validation.last_isal_collect_required'),
            'active.required'=>__('validation.active_required'),
        ];
    }
}
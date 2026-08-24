<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
            Rule::unique('suppliers', 'name')
                ->where('com_code', auth()->user()->com_code)
                ->ignore($this->route('id')),
        ],
            'active'=> 'required',
            'category_id'=> 'required',

        ];
    }
    public function messages(){
        return[
            'name.required'=>__('validation.name_required'),
            'name.unique'=>__('validation.name_unique'),
            'active.required'=> __('validation.active_required'),
            'category_id.required'=> __('validation.category_id_required'),
        ];
    }
}
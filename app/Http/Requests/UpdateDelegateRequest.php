<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDelegateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('delegates', 'name')->ignore($this->route('delegate')),
            ],

            'active' => 'required',
            'commission_type' => 'required',

            'percent_Wholesale_commission' => 'required|numeric|max:10',
            'percent_half_wholesale_commission' => 'required|numeric|max:10',
            'percent_retail_commission' => 'required|numeric|max:10',
            'percent_collect_commission' => 'required|numeric|max:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.unique' => __('validation.name_unique'),

            'active.required' => __('validation.active_required'),
            'commission_type.required' => __('validation.commission_type_required'),

            'percent_Wholesale_commission.required' => __('validation.percent_Wholesale_commission_required'),
            'percent_half_wholesale_commission.required' => __('validation.percent_half_wholesale_commission_required'),
            'percent_retail_commission.required' => __('validation.percent_retail_commission_required'),
            'percent_collect_commission.required' => __('validation.percent_collect_commission_required'),

            'percent_Wholesale_commission.max' => __('validation.percent_Wholesale_commission_max'),
            'percent_half_wholesale_commission.max' => __('validation.percent_half_wholesale_commission_max'),
            'percent_retail_commission.max' => __('validation.percent_retail_commission_max'),
            'percent_collect_commission.max' => __('validation.percent_collect_commission_max'),
        ];
    }
}
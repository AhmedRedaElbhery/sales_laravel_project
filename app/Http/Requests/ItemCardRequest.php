<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCardRequest extends FormRequest
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

            'barcode' => 'nullable|string|max:50',
            'name' => 'required',
            'item_type' => 'required',
            'category_id' => 'required',

            'unit_parent_id' => 'required',
            'Wholesale_price' => 'required_unless:unit_parent_id,null',
            'half_Wholesale_price' => 'required_unless:unit_parent_id,null',
            'price' => 'required_unless:unit_parent_id,null',
            'cost_price' => 'required_unless:unit_parent_id,null',

            'has_retail_unit' => 'required',
            'retail_units' => 'required_if:has_retail_unit,1',
            'retail_unit_to_parent' => 'required_if:has_retail_unit,1',
            'retail_Wholesale_price' => 'required_if:has_retail_unit,1',
            'retail_half_Wholesale_price' => 'required_if:has_retail_unit,1',
            'retail_price' => 'required_if:has_retail_unit,1',
            'retail_cost_price' => 'required_if:has_retail_unit,1',


            'has_fixed_price' => 'required',


            'active' => 'required|boolean',

        ];
    }
    public function messages()
    {
        return [
            'name.required' =>  __('validation.name_required'),
            'item_type.required' =>  __('validation.item_type_required'),
            'category_id.required' => __('validation.category_id_required'),


            'unit_parent_id.required' =>  __('validation.unit_parent_id_required'),
            'Wholesale_price.required_unless' => __('validation.Wholesale_price_required_unless'),
            'half_Wholesale_price.required_unless' =>  __('validation.half_Wholesale_price_required_unless'),
            'price.required_unless' =>  __('validation.price_required_unless'),
            'cost_price.required_unless' =>  __('validation.cost_price_required_unless'),



            'has_retail_unit.required' =>  __('validation.has_retail_unit_required'),
            'retail_units.required_if' =>   __('validation.retail_units_required_if'),
            'retail_unit_to_parent.required_if' =>  __('validation.retail_unit_to_parent_required_if'),
            'retail_Wholesale_price.required_if' =>   __('validation.retail_Wholesale_price_required_if'),
            'retail_half_Wholesale_price.required_if' =>  __('validation.retail_half_Wholesale_price_required_if'),
            'retail_price.required_if' =>   __('validation.retail_price_required_if'),
            'retail_cost_price.required_if' =>  __('validation.retail_cost_price_required_if'),


            'has_fixed_price.required'=> __('validation.has_fixed_price_required'),
            'active.required' => __('validation.active_required'),
        ];
    }
}
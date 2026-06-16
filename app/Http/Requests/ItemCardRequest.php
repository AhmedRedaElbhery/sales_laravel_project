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
            'name.required' => 'الاسم مطلوب',
            'item_type.required' => 'النوع مطلوب',
            'category_id.required' => 'الفئه مطلوب',


            'unit_parent_id.required' => 'الوحده الاساسيه مطلوب',
            'Wholesale_price.required_unless' => 'سعر الجمله الوحده الاساسيه مطلوب',
            'half_Wholesale_price.required_unless' => 'سعر نص جمله الوحده الاساسيه مطلوب',
            'price.required_unless' => 'سعر القطاعى للوحده الاساسيه مطلوب',
            'cost_price.required_unless' => 'سعر شراء الوحده الاساسيه مطلوب',



            'has_retail_unit.required' => 'ادخل هل الصنف له وحدات تجزئه ام لا',
            'retail_units.required_if' =>  'وحدات التجزئه للصنف مطلوبه',
            'retail_unit_to_parent.required_if' => 'عدد وحدات التجزئه للصنف مطلوبه',
            'retail_Wholesale_price.required_if' =>  'سعر الجمله لوحده التجزئه مطلوب',
            'retail_half_Wholesale_price.required_if' => 'سعر النص الجمله لوحده التجزئه مطلوب',
            'retail_price.required_if' =>  'سعر القطاعى لوحده التجزئه مطلوب',
            'retail_cost_price.required_if' =>  'سعر شراء وحده التجزئه مطلوب',


            'has_fixed_price.required'=>'ادخل الحاله',
            'active.required' => 'ادخل الحاله',
        ];
    }
}
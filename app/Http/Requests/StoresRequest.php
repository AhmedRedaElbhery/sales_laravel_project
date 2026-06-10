<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoresRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'phone' => [
                'required',
                'numeric',
                Rule::unique('stores', 'phone')->ignore($this->id),
            ],
            'active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'address.required' => 'العنوان مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.numeric' => 'ادخل رقم هاتف صحيح',
            'phone.unique' => 'هذا الهاتف موجود بالفعل',
            'active.required' => 'ادخل الحاله',
        ];
    }
}
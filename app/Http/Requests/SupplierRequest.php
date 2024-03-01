<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
            'TenNCC' => 'required',
            'DiaChi' => 'required',
            'SDT' => 'required|numeric',
        ];
    }
    public function messages(): array
    {
        return [            
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi.required' => 'Địa chỉ nhà cung cấp không được để trống',
            'SDT.required' => 'Số điện thoại nhà cung cấp không được để trống',
            'SDT.numeric' => 'Số điện thoại phải là chuỗi số',
            'SDT.max' => 'Số điện thoại có tối đa 10 chữ số',
        ];
    }  
}

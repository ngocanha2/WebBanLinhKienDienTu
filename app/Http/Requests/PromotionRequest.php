<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FailedReturnJsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'TyLeGiamGia' => 'required|numeric|min:0|max:100',
            'NgayBatDau' => 'required|date|',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
        ];
    }
    public function messages(): array
    {
        return [
            'TyLeGiamGia.required' => 'Tỷ lệ giảm giá không được để trống',
            'TyLeGiamGia.numeric' => 'Tỷ lệ giảm giá phải là kiểu số',            
            'TyLeGiamGia.min' => 'Tỷ lệ giảm giá thấp nhất là 0',            
            'TyLeGiamGia.max' => 'Tỷ lệ giảm giá cao nhất là 100',            
            'NgayBatDau.required' => 'Ngày bắt đầu không được để trống',
            'NgayBatDau.date' => 'Ngày bắt đầu phải là định dạng thời gian',            
            'NgayKetThuc.required' => 'Ngày kết thúc không được để trống',
            'NgayKetThuc.date' => 'Ngày kết thúc là định dạng thời gian',
            'NgayKetThuc.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đâu',
        ];
    }  
}

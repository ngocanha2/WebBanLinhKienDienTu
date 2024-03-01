<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FailedReturnJsonFormRequest
{   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
            'MucDoHaiLong' => 'required',
            'NoiDungDanhGia' => 'required',
            // 'AnDanh' => 'boolean',
        ];
    }
    public function messages(): array
    {
        return [            
            'MucDoHaiLong.required' => 'Mức độ hài lòng không được để trống',
            'NoiDungDanhGia.required' => 'Nội dung đánh giá không được để trống',
            // 'AnDanh.boolean' => 'Ẩn danh phải là kiểu đúng sai',         
        ];
    }  
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FailedReturnJsonFormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|min:3',
            'email' => 'required|email',                     
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required',            
        ];
    }
    public function messages(): array
    {
        return [                      
            'full_name.required' => 'Họ và tên không được để trống',                
            'email.required' => 'Email không được để trống',                
            'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu của bạn',             
            'email.email' => "Email không đúng định dạng",
            'password.confirmed' => "Mật khẩu nhập lại không khớp",           
        ];
    }     
}

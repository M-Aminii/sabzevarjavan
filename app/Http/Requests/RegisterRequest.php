<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|min:2',
            'last_name'      => 'required|string|min:2',
            'mobile'         => 'required|regex:/^09[0-9]{9}$/|unique:users,mobile',
            'national_code'  => 'required|digits:10|unique:users,national_code',
            'birth_date'     => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'لطفاً نام خود را وارد کنید.',
            'name.min'                => 'نام باید حداقل دو حرف باشد.',
            'last_name.required'      => 'لطفاً نام خانوادگی را وارد کنید.',
            'last_name.min'           => 'نام خانوادگی باید حداقل دو حرف باشد.',
            'mobile.required'         => 'شماره موبایل الزامی است.',
            'mobile.regex'            => 'فرمت شماره موبایل نادرست است.',
            'mobile.unique'           => 'شما از قبل ثبت‌نام کرده‌اید (شماره موبایل تکراری است).',
            'national_code.required'  => 'کد ملی الزامی است.',
            'national_code.digits'    => 'کد ملی باید دقیقاً ۱۰ رقم باشد.',
            'national_code.unique'    => 'کد ملی واردشده قبلاً ثبت شده است.',
            'birth_date.required'     => 'تاریخ تولد را وارد کنید.',
        ];
    }
}

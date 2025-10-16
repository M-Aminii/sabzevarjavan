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
            'first_name'         => 'required|string|min:2',
            'last_name'          => 'required|string|min:2',
            'mobile'             => 'required|regex:/^09[0-9]{9}$/|unique:users,mobile',
            'national_code'      => 'required|digits:10|unique:users,national_code',
            'birth_date'         => 'required',
            'gender'             => 'required|in:male,female',
            'marital_status'     => 'required|in:single,married',
            'address'            => 'required|string',
            'employment_status'  => 'required|in:employed,unemployed,student,retired',
            'company_name'       => 'required_if:employment_status,employed|string|nullable',
            'job_title'          => 'required_if:employment_status,employed|string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'         => 'نام الزامی است.',
            'last_name.required'          => 'نام خانوادگی الزامی است.',
            'mobile.required'             => 'شماره موبایل الزامی است.',
            'mobile.regex'                => 'فرمت شماره موبایل نادرست است.',
            'mobile.unique'               => 'این شماره موبایل قبلاً ثبت شده است.',
            'national_code.required'      => 'کد ملی الزامی است.',
            'national_code.digits'        => 'کد ملی باید دقیقاً ۱۰ رقم باشد.',
            'national_code.unique'        => 'کد ملی واردشده قبلاً ثبت شده است.',
            'birth_date.required'         => 'تاریخ تولد را وارد کنید.',
            'gender.required'             => 'جنسیت را انتخاب کنید.',
            'marital_status.required'     => 'وضعیت تأهل را انتخاب کنید.',
            'address.required'            => 'نشانی را وارد کنید.',
            'employment_status.required'  => 'وضعیت اشتغال الزامی است.',
            'employment_status.in'        => 'وضعیت اشتغال انتخاب‌شده معتبر نیست.',
            'company_name.required_if'    => 'در صورت شاغل بودن، نام شرکت یا سازمان الزامی است.',
            'job_title.required_if'       => 'در صورت شاغل بودن، عنوان شغلی الزامی است.',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use App\Http\Requests\RegisterRequest;
use App\Helpers\SmsHelper;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(RegisterRequest $request)
    {
        try {
            $birthDateMiladi = Jalalian::fromFormat('Y/m/d', $request->birth_date)
                ->toCarbon()
                ->toDateString();

            $birth = Carbon::parse($birthDateMiladi);
            $age = $birth->age;

            if ($age < 14 || $age > 45) {
                return redirect()->back()
                    ->with('error', '⚠️ محدوده مجاز سنی برای ثبت نام ۱۴ تا ۴۵ سال می‌باشد.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            return back()
                ->withErrors(['birth_date' => 'تاریخ تولد نامعتبر است.'])
                ->withInput();
        }

        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'mobile'            => $request->mobile,
            'national_code'     => $request->national_code,
            'birth_date'        => $birthDateMiladi,
            'gender'            => $request->gender,
            'marital_status'    => $request->marital_status,
            'address'           => $request->address,
            'employment_status' => $request->employment_status,
            'company_name'      => $request->company_name,
            'job_title'         => $request->job_title,
        ]);

        try {
            $message = "ثبت نام شما با موفقیت انجام شد.\nستاد ساماندهی امور جوانان شهرستان سبزوار";
            SmsHelper::send($user->mobile, $message);
        } catch (\Exception $e) {
            Log::error('SMS ارسال نشد: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', '✅ ثبت‌ نام با موفقیت انجام شد.');
    }


    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^09[0-9]{9}$/|exists:users,mobile',
        ], [
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex'    => 'فرمت شماره موبایل نادرست است.',
            'mobile.exists'   => 'این شماره در سیستم ثبت نشده است.',
        ]);

        $code = rand(100000, 999999);

        OtpCode::updateOrCreate(
            ['mobile' => $request->mobile],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(2),
            ]
        );

        Log::info("کد تأیید برای {$request->mobile}: {$code}");

        return redirect()->route('auth.verify')->with([
            'mobile' => $request->mobile,
            'message' => 'کد تأیید برای شما ارسال شد (اعتبار ۲ دقیقه).',
        ]);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'code'   => 'required|digits:6',
        ]);

        $otp = OtpCode::where('mobile', $request->mobile)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['code' => 'کد تأیید نادرست یا منقضی شده است.']);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return back()->withErrors(['mobile' => 'کاربر یافت نشد.']);
        }

        Auth::login($user);

        $otp->delete();

        return redirect('/dashboard')->with('success', 'به حساب کاربری خود وارد شدید.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'از حساب خود خارج شدید.');
    }
}

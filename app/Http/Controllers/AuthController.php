<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Morilog\Jalali\Jalalian;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $birthDateMiladi = Jalalian::fromFormat('Y/m/d', $request->birth_date)
                ->toCarbon()
                ->toDateString();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['birth_date' => 'تاریخ تولد نامعتبر است.'])
                ->withInput();
        }

        User::create([
            'name'          => $request->name,
            'last_name'     => $request->last_name,
            'mobile'        => $request->mobile,
            'national_code' => $request->national_code,
            'birth_date'    => $birthDateMiladi,
        ]);

        return redirect()->back()->with('success', '✅ ثبت‌نام با موفقیت انجام شد! حالا وارد شوید.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('mobile', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'شماره موبایل یا رمز عبور اشتباه است.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

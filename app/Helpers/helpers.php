<?php

use Morilog\Jalali\Jalalian;

if (!function_exists('convertPersianNumbersToEnglish')) {
    /**
     * تبدیل اعداد فارسی و عربی به انگلیسی
     */
    function convertPersianNumbersToEnglish($string)
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];

        return str_replace($persian, $english, str_replace($arabic, $english, $string));
    }
}

if (!function_exists('convertJalaliToGregorian')) {
    /**
     * تبدیل تاریخ شمسی (اعداد فارسی یا انگلیسی) به میلادی
     * خروجی: yyyy-mm-dd
     */
    function convertJalaliToGregorian($jalaliDate)
    {
        try {
            $cleanDate = convertPersianNumbersToEnglish($jalaliDate);

            return Jalalian::fromFormat('Y/m/d', $cleanDate)
                ->toCarbon()
                ->toDateString();
        } catch (\Exception $e) {
            return null; // در صورت خطا null برمی‌گردونه
        }
    }
}

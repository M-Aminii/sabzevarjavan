{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ثبت نام</title>

  <!-- فونت (اختیاری) -->
  <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet" />

  <!-- CSS سفارشی -->
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">

  <!-- Persian datepicker css (در صورت نیاز) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>
<body>

  <div class="card">
    <h1 class="title">فرم ثبت نام</h1>
    <p class="subtitle">ایجاد حساب جدید</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif


    <form method="POST" action="{{ route('register') }}" class="form">
  @csrf

  <div class="row">
    <div class="half-width">
      <label for="first_name">نام <span class="required">*</span></label>
      <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
      @error('first_name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="half-width">
      <label for="last_name">نام خانوادگی <span class="required">*</span></label>
      <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
      @error('last_name') <div class="error">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="row">
    <div class="half-width">
      <label for="mobile">تلفن (موبایل) <span class="required">*</span></label>
      <input type="text" name="mobile" id="mobile" placeholder="09xxxxxxxxx" value="{{ old('mobile') }}" required>
      @error('mobile') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="half-width">
      <label for="national_code">کد ملی <span class="required">*</span></label>
      <input type="text" name="national_code" id="national_code" value="{{ old('national_code') }}" required>
      @error('national_code') <div class="error">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="row">
    <div class="half-width">
      <label for="birth_date_shamsi">تاریخ تولد <span class="required">*</span></label>
      <input type="text" id="birth_date_shamsi" placeholder="مثلاً 1379/05/23" value="{{ old('birth_date') }}">
      <input type="hidden" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
      @error('birth_date') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="half-width">
      <label for="gender">جنسیت <span class="required">*</span></label>
      <select name="gender" id="gender">
        <option value="">انتخاب کنید</option>
        <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>مرد</option>
        <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>زن</option>
      </select>
      @error('gender') <div class="error">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="row">
    <div class="half-width">
      <label for="marital_status">وضعیت تأهل <span class="required">*</span></label>
      <select name="marital_status" id="marital_status">
        <option value="">انتخاب کنید</option>
        <option value="single" {{ old('marital_status')=='single' ? 'selected' : '' }}>مجرد</option>
        <option value="married" {{ old('marital_status')=='married' ? 'selected' : '' }}>متأهل</option>
      </select>
      @error('marital_status') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="half-width">
      <label for="employment_status">وضعیت اشتغال <span class="required">*</span></label>
      <select name="employment_status" id="employment_status" required>
        <option value="">انتخاب کنید</option>
        <option value="employed" {{ old('employment_status')=='employed' ? 'selected' : '' }}>شاغل</option>
        <option value="unemployed" {{ old('employment_status')=='unemployed' ? 'selected' : '' }}>بیکار</option>
        <option value="student" {{ old('employment_status')=='student' ? 'selected' : '' }}>دانشجو</option>
        <option value="retired" {{ old('employment_status')=='retired' ? 'selected' : '' }}>بازنشسته</option>
      </select>
      @error('employment_status') <div class="error">{{ $message }}</div> @enderror
    </div>
  </div>

<div id="jobFields" class="hidden-block row">
    <div class="third-width">
      <label for="company_name">نام شرکت یا سازمان <span class="required">*</span></label>
      <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}">
      @error('company_name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="third-width">
      <label for="job_title">عنوان شغلی <span class="required">*</span></label>
      <input type="text" name="job_title" id="job_title" value="{{ old('job_title') }}">
      @error('job_title') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>


  <div class="row">
    <div class="full-width">
      <label for="address">نشانی <span class="required">*</span></label>
      <textarea name="address" id="address">{{ old('address') }}</textarea>
    </div>
  </div>

  <button type="submit" class="submit-btn">ثبت نام</button>
</form>

  </div>

<!-- اسکریپت‌ها -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="{{ asset('js/register.js') }}"></script>
</body>
</html>

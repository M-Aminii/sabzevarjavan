<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ورود / ثبت‌نام</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
  <div class="tabs">
    <div class="tab active" id="loginTab">ورود</div>
    <div class="tab" id="registerTab">ثبت‌نام</div>
    <div class="tab-underline"></div>
  </div>

  <!-- فرم ورود -->
  <form id="loginForm" class="login-form" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="input-group">
      <input type="text" name="mobile" placeholder="شماره موبایل" required>
    </div>
    <div class="input-group">
      <input type="password" name="password" placeholder="رمز عبور" required>
    </div>
    <button type="submit" class="sign-in-btn">ورود</button>
  </form>

  <!-- فرم ثبت‌نام -->
  <form id="registerForm" class="login-form" method="POST" action="{{ route('register') }}" style="display:none;">
    @csrf

    <div class="input-group">
      <input type="text" name="name" placeholder="نام" value="{{ old('name') }}" required>
    </div>

    <div class="input-group">
      <input type="text" name="last_name" placeholder="نام خانوادگی" value="{{ old('last_name') }}" required>
    </div>

    <div class="input-group">
      <input type="text" name="mobile" placeholder="شماره موبایل (مثلاً 09123456789)" value="{{ old('mobile') }}" required>
    </div>

    <div class="input-group">
      <input type="text" name="national_code" placeholder="کد ملی" value="{{ old('national_code') }}" required>
    </div>

    <div class="input-group">
      <input type="text" id="birth_date_shamsi" placeholder="تاریخ تولد (مثلاً 1379/05/23)" value="{{ old('birth_date') }}" required>
      <input type="hidden" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
    </div>

    <button class="sign-in-btn" type="submit">ثبت‌نام</button>
  </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>

<script>
  $("#birth_date_shamsi").persianDatepicker({
    format: 'YYYY/MM/DD',
    altField: '#birth_date',
    altFormat: 'YYYY/MM/DD',
    observer: true,
    initialValue: false,
    autoClose: true,
    onSelect: function() {
      let val = $("#birth_date").val()
        .replace(/۰/g, "0")
        .replace(/۱/g, "1")
        .replace(/۲/g, "2")
        .replace(/۳/g, "3")
        .replace(/۴/g, "4")
        .replace(/۵/g, "5")
        .replace(/۶/g, "6")
        .replace(/۷/g, "7")
        .replace(/۸/g, "8")
        .replace(/۹/g, "9");
      $("#birth_date").val(val);
    }
  });

  $(document).ready(function() {
    @if ($errors->any())
      let errorMessages = '';
      @foreach ($errors->all() as $error)
        errorMessages += '• {{ $error }}<br>';
      @endforeach
      Swal.fire({
        icon: 'error',
        title: 'خطا در ارسال فرم',
        html: errorMessages,
        confirmButtonText: 'باشه',
        confirmButtonColor: '#d33',
      });
    @endif

    @if (session('success'))
      Swal.fire({
        icon: 'success',
        title: 'موفق!',
        text: '{{ session('success') }}',
        confirmButtonText: 'باشه',
        confirmButtonColor: '#28a745',
      });
    @endif
  });
</script>

</body>
</html>

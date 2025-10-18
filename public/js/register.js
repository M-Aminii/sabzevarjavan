document.addEventListener('DOMContentLoaded', function () {
    // ✅ نمایش انیمیشنی هشدارها
    ['alert-success', 'alert-warning'].forEach(cls => {
        const el = document.querySelector('.' + cls);
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => {
                el.style.transition = 'opacity 0.6s ease';
                el.style.opacity = '1';
            }, 150);
        }
    });

    // ✅ کنترل وضعیت اشتغال
    const employment = document.getElementById('employment_status');
    const jobFields = document.getElementById('jobFields');
    function toggleJobFields() {
        if (!employment) return;
        jobFields.style.display = employment.value === 'employed' ? 'flex' : 'none';
    }
    if (employment) {
        employment.addEventListener('change', toggleJobFields);
        toggleJobFields();
    }

    if (window.$ && $('#calendarTrigger').length) {
        $('#calendarTrigger').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#birth_date',
            altFormat: 'YYYY/MM/DD',
            observer: true,
            initialValue: false,
            responsive: true,
            autoClose: true,
            timePicker: { enabled: false },
            toolbox: { calendarSwitch: { enabled: false } },
            calendar: {
                persian: {
                    locale: 'fa',
                    leapYearMode: 'astronomical'
                }
            },
            persianDigit: false,
            keyboardNavigation: true,
            responsive: true,
            onSelect: function (unixDate) {
                const date = new persianDate(unixDate).format('YYYY/MM/DD');
                $('#birth_date').val(date);
                $('#birth_date_shamsi').val(date);
            }
        });
    }

    $('#birth_date_shamsi').on('input', function () {
        let value = $(this).val().replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
        const regex = /^13[0-9]{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/;
        if (regex.test(value)) {
            $('#birth_date').val(value);
        }
    });

});

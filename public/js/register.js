document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.querySelector('.alert-success');
    if (alertBox) {
        alertBox.style.opacity = '0';
        setTimeout(() => {
            alertBox.style.transition = 'opacity 0.6s ease';
            alertBox.style.opacity = '1';
        }, 150);
    }

    const warningBox = document.querySelector('.alert-warning');
    if (warningBox) {
        warningBox.style.opacity = '0';
        setTimeout(() => {
            warningBox.style.transition = 'opacity 0.6s ease';
            warningBox.style.opacity = '1';
        }, 150);
    }

    const employment = document.getElementById('employment_status');
    const jobFields = document.getElementById('jobFields');
    function toggleJobFields() {
        if (!employment) return;
        if (employment.value === 'employed') {
            jobFields.style.display = 'block';
        } else {
            jobFields.style.display = 'none';
        }
    }
    if (employment) {
        employment.addEventListener('change', toggleJobFields);
        toggleJobFields();
    }

    $('#birth_date_shamsi').persianDatepicker({
        format: 'YYYY/MM/DD',
        altField: '#birth_date',
        altFormat: 'YYYY/MM/DD',
        observer: true,
        initialValue: false,
        autoClose: true,
        timePicker: { enabled: false },
        toolbox: { calendarSwitch: { enabled: false } },
        calendar: {
            persian: {
                locale: 'en',
                leapYearMode: 'astronomical'
            }
        },
        persianDigit: false,
        keyboardNavigation: true,
        onSelect: function (unixDate) {
            const date = new persianDate(unixDate).format('YYYY/MM/DD');
            $('#birth_date').val(date);
        }
    });

    $('#birth_date_shamsi').on('input', function () {
        let value = $(this).val().replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
        const regex = /^13[0-9]{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/;
        if (regex.test(value)) {
            $('#birth_date').val(value);
        }
    });


});

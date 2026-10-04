import intlTelInput from 'intl-tel-input';

import 'intl-tel-input/styles';

export function initContactPhone(): void {
    const input =
        document.querySelector<HTMLInputElement>('#phone-display');

    if (!input) return;

    const form = input.closest('form');
    const error = document.querySelector<HTMLElement>('#phone-error');

    if (!form || !error) return;

    const phone = intlTelInput(input, {
        initialCountry: 'us',

        countryOrder: ['us', 'ca', 'gb', 'au'],

        separateDialCode: true,

        strictMode: true,

        formatAsYouType: true,

        hiddenInputs: () => ({
            phone: 'phone',
            country: 'phone_country',
        }),

        loadUtils: () => import('intl-tel-input/utils'),
    });

    let ready = false;

    phone.promise.then(() => {
        ready = true;
    }).catch(() => {
        error.textContent =
            'Phone validation is unavailable. Please leave the optional phone field blank.';
    });

    input.addEventListener('input', () => {
        error.textContent = '';
        input.setCustomValidity('');
    });

    form.addEventListener('submit', (event) => {
        const enteredNumber = input.value.trim();

        // This field is optional.
        if (!enteredNumber) {
            input.setCustomValidity('');
            return;
        }

        // Avoid submitting a number before its validation tools load.
        if (!ready) {
            event.preventDefault();

            error.textContent =
                'Phone validation is still loading. Please try again.';

            return;
        }

        if (!phone.isValidNumber()) {
            event.preventDefault();

            const message =
                'Please enter a valid phone number for the selected country.';

            error.textContent = message;
            input.setCustomValidity(message);
            input.reportValidity();

            return;
        }

        // The library's hiddenInputs configuration automatically
        // adds the E.164 number and country to the normal form POST.
        input.setCustomValidity('');
        error.textContent = '';
    });
}
export function initContactPrivacy(): void {
    const emailButton =
        document.getElementById('copy-business-email') as HTMLButtonElement | null;

    const phoneButton =
        document.getElementById('copy-business-phone') as HTMLButtonElement | null;

    const emailStatus =
        document.getElementById('copy-email-status') as HTMLParagraphElement | null;

    const phoneStatus =
        document.getElementById('copy-phone-status') as HTMLParagraphElement | null;

    const resetState = (): void => {
        if (emailButton) {
            emailButton.textContent = 'Copy Email Address';
        }

        if (phoneButton) {
            phoneButton.textContent = 'Copy Phone Number';
        }

        if (emailStatus) {
            emailStatus.textContent = '';
        }

        if (phoneStatus) {
            phoneStatus.textContent = '';
        }
    };

    emailButton?.addEventListener('click', async () => {
        resetState();

        const email = emailButton.dataset.email;

        if (!email) {
            return;
        }

        try {
            await navigator.clipboard.writeText(email);

            emailButton.textContent = 'Copied!';

            if (emailStatus) {
                emailStatus.textContent = 'Email address copied.';
            }
        } catch {
            if (emailStatus) {
                emailStatus.textContent =
                    'Please select and copy the email address above.';
            }
        }
    });

    phoneButton?.addEventListener('click', async () => {
        resetState();

        const phone = phoneButton.dataset.phone;

        if (!phone) {
            return;
        }

        try {
            await navigator.clipboard.writeText(phone);

            phoneButton.textContent = 'Copied!';

            if (phoneStatus) {
                phoneStatus.textContent = 'Phone number copied.';
            }
        } catch {
            if (phoneStatus) {
                phoneStatus.textContent =
                    'Please select and copy the phone number above.';
            }
        }
    });
}
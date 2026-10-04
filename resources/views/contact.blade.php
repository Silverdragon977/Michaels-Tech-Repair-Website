{{-- Contact Blade --}}

@extends('layouts.app')

@section('title', "Contact | Michael's Tech Repair")

@section('content')

<main class="contact-page">

    <section class="section contact-hero">
        <div class="page-container">

            <span class="section-heading__eyebrow">
                Contact Michael's Tech Repair
            </span>

            <h1 class="contact-hero__title">
                Let's Get Your Technology Working.
            </h1>

            <p class="contact-hero__lead">
                Have a question, need assistance, or have a project
                in mind? Choose whichever contact method works best.
            </p>

        </div>
    </section>

    <section class="section contact-methods">
        <div class="page-container">

            <div class="contact-grid">

                {{-- LEFT: CONTACT FORM --}}
                <section class="contact-card contact-card--form">

                    <h2>Send a Message</h2>

                    <p>
                        Describe your issue or project and I'll review
                        your request.
                    </p>

                    @if (session('contact_success'))
                        <div class="contact-alert contact-alert--success"
                             role="status">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if ($errors->has('contact'))
                        <div class="contact-alert contact-alert--error"
                             role="alert">
                            {{ $errors->first('contact') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}"
                          method="POST"
                          class="contact-form">

                        @csrf

                        {{-- Honeypot --}}
                        <div class="contact-form__honeypot"
                             aria-hidden="true">
                            <label for="website">Leave this blank</label>
                            <input
                                type="text"
                                name="website"
                                id="website"
                                tabindex="-1"
                                autocomplete="off"
                            >
                        </div>

                        <div class="contact-form__row">

                            <div class="contact-form__field">
                                <label for="name">Name *</label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    autocomplete="name"
                                    maxlength="100"
                                    required
                                    aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                >
                                @error('name')
                                    <span class="contact-form__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact-form__field">
                                <label for="email">Email *</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    maxlength="254"
                                    required
                                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                >
                                @error('email')
                                    <span class="contact-form__error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="contact-form__field">
                            <label for="phone">Phone (optional)</label>
                            <input
                                id="phone"
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                maxlength="30"
                            >
                        </div>

                        <div class="contact-form__field">
                            <label for="service">What do you need help with? *</label>

                            <select id="service" name="service" required>
                                <option value="">Select a service...</option>

                                @foreach ([
                                    'computer-repair' => 'Computer Repair',
                                    'virus-removal' => 'Virus Removal',
                                    'home-tech-setup' => 'Home Tech Setup',
                                    'device-troubleshooting' => 'Troubleshooting Devices',
                                    'website-creation' => 'Website Creation & Maintenance',
                                    'pc-builds' => 'PC Builds & Upgrades',
                                    'media-servers' => 'Media Server Setup',
                                    'network-setup' => 'Network Setup',
                                    'cloud-server' => 'Cloud & Server Administration',
                                    'other' => 'Other / Not Sure',
                                ] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('service') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('service')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="contact-form__field">
                            <label for="message">Tell me about it *</label>

                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                minlength="15"
                                maxlength="5000"
                                placeholder="Describe what's happening or what you're trying to accomplish..."
                                required
                            >{{ old('message') }}</textarea>

                            @error('message')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="button button--primary">
                            Send Message
                        </button>

                        <p class="contact-form__note">
                            Your information is used to respond to your inquiry.
                            Please don't include passwords or sensitive account details.
                        </p>

                    </form>
                </section>


                {{-- RIGHT: DIRECT CONTACT --}}
                <aside class="contact-card contact-card--direct">

                    <div class="contact-card__heading">
                        <span class="contact-card__icon" aria-hidden="true">
                            &#9993;
                        </span>
                        <h2>Contact Directly</h2>
                    </div>

                    <p>
                        Prefer your own email application? Copy my business
                        address and contact me directly.
                    </p>

                    <div class="contact-email">

                        <span id="business-email"
                              class="contact-email__address">
                            contact@michaelstechrepair.com
                        </span>

                        <button
                            type="button"
                            class="button button--secondary"
                            id="copy-business-email"
                            data-email="contact@michaelstechrepair.com"
                        >
                            Copy Email Address
                        </button>

                    </div>

                    <p class="contact-email__status"
                       id="copy-email-status"
                       role="status"
                       aria-live="polite"></p>

                    <div class="contact-card__details">
                        <h3>Not Sure Where to Start?</h3>

                        <p>
                            You don't need to diagnose the technical issue.
                            A brief explanation is enough to get the
                            conversation started.
                        </p>

                        <p>
                            I assist with everyday technology problems,
                            custom websites, computer hardware, home
                            networking, and server projects.
                        </p>
                    </div>

                </aside>

            </div>

        </div>
    </section>

</main>

@include('layouts.footer')

<script>
(() => {
    const button = document.getElementById('copy-business-email');
    const status = document.getElementById('copy-email-status');

    if (!button || !status) return;

    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.email);
            button.textContent = 'Copied!';
            status.textContent = 'Email address copied.';
        } catch {
            status.textContent =
                'Please select and copy the email address above.';
        }
    });
})();
</script>

@endsection
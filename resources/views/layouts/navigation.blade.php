
{{-- ==========================================
    NAVIGATION
=========================================== --}}

<header class="site-header">

    <div class="site-header__inner">

        {{-- BRAND --}}
        <a href="{{ route('home') }}" class="site-header__brand">

        <img
            src="{{ asset('images/branding/logo.webp') }}"
            alt=""
            class="site-header__logo"
            width="40"
            height="40"
        >
            
            <span>Michael's Tech Repair</span>
        </a>

        {{-- NAVIGATION LINKS --}}
        <nav class="site-header__nav" aria-label="Main Navigation">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}#services">Services</a>
            <a href="{{ route('about') }}#about">About</a>
            <a href="{{ route('contact') }}#contact">Contact</a>
        </nav>


        {{-- PRIMARY ACTION --}}
        <div class="site-header__action">

            <a href="{{ route('contact') }}#contact" class="button button--primary">
                Get Help
            </a>

        </div>

    </div>

</header>

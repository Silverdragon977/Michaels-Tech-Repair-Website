
{{-- ==========================================
    NAVIGATION
=========================================== --}}

<header class="site-header">

    <div class="site-header__inner">

        {{-- BRAND --}}
        <a href="{{ route('home') }}" class="site-header__brand">

            <div class="placeholder placeholder--logo">
                Logo
            </div>
            
            <span>Michael's Tech Repair</span>
        </a>

        {{-- NAVIGATION LINKS --}}
        <nav class="site-header__nav" aria-label="Main Navigation">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}#services">Services</a>
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('home') }}#contact">Contact</a>
        </nav>


        {{-- PRIMARY ACTION --}}
        <div class="site-header__action">

            <a href="{{ route('home') }}#contact" class="button button--primary">
                Get Help
            </a>

        </div>

    </div>

</header>

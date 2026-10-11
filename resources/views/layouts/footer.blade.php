{{-- ==========================================
    FOOTER
=========================================== --}}

<footer class="site-footer">

    <div class="page-container">

        <div class="site-footer__grid">

            {{-- BRAND --}}
            <div class="site-footer__brand">

                <a href="{{ route('home') }}" class="site-footer__brand-link">

                    <img
                        src="{{ asset('images/branding/logo-footer.webp') }}"
                        alt="Michael's Tech Repair"
                        class="site-footer__logo"
                        loading="lazy"
                    >

                </a>

                <p class="site-footer__tagline">
                    Practical technology help for your home,
                    computer, and online projects.
                </p>

            </div>


            {{-- NAVIGATION --}}
            <div class="site-footer__links">
            
                <h3 class="site-footer__heading">
                    Quick Links
                </h3>
            
                <nav class="site-footer__nav" aria-label="Footer navigation">
                
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('home') }}#services">Services</a>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('contact') }}">Contact</a>
                
                </nav>
            
            </div>


            {{-- CONTACT --}}
            <div class="site-footer__contact">

                <h3>Get in Touch</h3>

                <p>
                    Need help with something technical?
                    Reach out to discuss your project or problem.
                </p>

                <a
                    href="{{ route('contact') }}#contact"
                    class="site-footer__contact-link"
                >
                    Contact Me &rarr;
                </a>

            </div>

        </div>


        {{-- COPYRIGHT --}}
        <div class="site-footer__bottom">

            <span>
                &copy; {{ date('Y') }} Michael's Tech Repair.
                All rights reserved.
            </span>

            <span class="site-footer__bottom-note">
                Independently operated in Minnesota.
            </span>

        </div>

    </div>

</footer>
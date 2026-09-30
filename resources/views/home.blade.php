@extends('layouts.app')

@section('content')

<main class="home">

    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="hero">

        <div class="page-container">

            <header class="site-header">

                <div class="site-header__brand">
                    <div class="placeholder placeholder--logo">
                        Logo
                    </div>

                    <span>Michael's Tech Repair</span>
                </div>

                <nav class="site-header__nav">
                    <a href="#">Home</a>
                    <a href="#">Services</a>
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                </nav>

                <div class="site-header__action">
                    <a href="#" class="button button--primary">
                        Get Help
                    </a>
                </div>

            </header>


            <div class="hero__content">

                <div class="hero__eyebrow">
                    Placeholder eyebrow
                </div>

                <h1 class="hero__title">
                    Placeholder Main Heading
                </h1>

                <p class="hero__description">
                    Placeholder introductory text goes here.
                </p>

                <div class="hero__actions">

                    <a href="#" class="button">
                        Primary Button
                    </a>

                    <a href="#" class="button">
                        Secondary Button
                    </a>

                </div>

                <div class="hero__meta">
                    Placeholder • Placeholder • Placeholder
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        SERVICES
    ====================================================== --}}
    <section class="section services">

        <div class="page-container">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    Services
                </span>

                <h2 class="section-heading__title">
                    How I Can Help
                </h2>

            </header>


            <div class="service-grid">

                @for ($i = 1; $i <= 9; $i++)

                    <article class="service-card">

                        <div class="placeholder placeholder--icon">
                            Icon
                        </div>

                        <div class="service-card__content">

                            <h3>


                                {{-- Later on make a key value pair and index with value instead of using multiple if-else statements. --}}
                                <?php if ($i == 1 ) {
                                    echo 'Computer Repair';
                                } elseif ($i == 2) {
                                    echo 'Virus Removal';
                                } elseif ($i == 3) {
                                    echo 'Home Tech Setup';
                                } elseif ($i == 4) {
                                    echo 'Troubleshooting Devices';
                                } elseif ($i == 5) {
                                    echo 'Website Creation & Maintenance';
                                } elseif ($i == 6) {
                                    echo 'PC Builds & Upgrades';
                                } elseif ($i == 7) {
                                    echo 'Media Server Setup';
                                } elseif ($i == 8) {
                                    echo 'Network Setup';
                                } elseif ($i == 9) {
                                    echo 'Cloud & Server Administration';
                                }?>
                            </h3>

                            <p>
                                <?php if ($i == 1 ) {
                                    echo 'Description for Computer Repair';
                                } elseif ($i == 2) {
                                    echo 'Description for Virus Removal';
                                } elseif ($i == 3) {
                                    echo 'Description for Home Tech Setup';
                                } elseif ($i == 4) {
                                    echo 'Description for Troubleshooting Devices';
                                } elseif ($i == 5) {
                                    echo 'Description for Website Creation & Maintenance';
                                } elseif ($i == 6) {
                                    echo 'Description for PC Builds & Upgrades';
                                } elseif ($i == 7) {
                                    echo 'Description for Media Server Setup';
                                } elseif ($i == 8) {
                                    echo 'Description for Network Setup';
                                } elseif ($i == 9) {
                                    echo 'Description for Cloud & Server Administration';
                                }?>
                            </p>

                            <a href="#">
                                <?php if ($i == 1 ) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 2) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 3) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 4) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 5) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 6) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 7) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 8) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                } elseif ($i == 9) {
                                    echo '<a href="{{  }}">Learn more</a>';
                                }?>
                            </a>

                        </div>

                    </article>

                @endfor

            </div>


            <aside class="problem-cta">

                <div class="problem-cta__content">

                    <h3>
                        Placeholder CTA Heading
                    </h3>

                    <p>
                        Placeholder CTA text.
                    </p>

                </div>

                <div class="problem-cta__action">

                    <a href="#" class="button">
                        CTA Button
                    </a>

                </div>

            </aside>

        </div>

    </section>


    {{-- =====================================================
        BENEFITS
    ====================================================== --}}
    <section class="section benefits">

        <div class="page-container">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    Placeholder
                </span>

                <h2 class="section-heading__title">
                    Why Choose Michael's Tech Repair
                </h2>

            </header>


            <div class="benefit-grid">

                @for ($i = 1; $i <= 5; $i++)

                    <article class="benefit">

                        <div class="placeholder placeholder--icon">
                            Icon
                        </div>

                        <h3>
                            Benefit {{ $i }}
                        </h3>

                        <p>
                            Placeholder description.
                        </p>

                    </article>

                @endfor

            </div>

        </div>

    </section>


    {{-- =====================================================
        ABOUT PREVIEW
    ====================================================== --}}
    <section class="section about-preview">

        <div class="page-container">

            <div class="about-preview__grid">

                <div class="about-preview__media">

                    <div class="placeholder placeholder--image">
                        Image
                    </div>

                </div>


                <div class="about-preview__content">

                    <span class="section-heading__eyebrow">
                        About
                    </span>

                    <h2>
                        Placeholder About Heading
                    </h2>

                    <p>
                        Placeholder About text.
                    </p>

                    <a href="#" class="button">
                        About Button
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        CONTACT CTA
    ====================================================== --}}
    <section class="section contact-cta">

        <div class="page-container">

            <div class="contact-cta__content">

                <span class="section-heading__eyebrow">
                    Placeholder
                </span>

                <h2>
                    Placeholder Contact Heading
                </h2>

                <p>
                    Placeholder contact description.
                </p>

                <div class="contact-cta__actions">

                    <a href="#" class="button">
                        Contact Form
                    </a>

                    <a href="#" class="button">
                        Email
                    </a>

                </div>

            </div>

        </div>

    </section>


</main>


{{-- =====================================================
    FOOTER
====================================================== --}}
<footer class="site-footer">

    <div class="page-container">

        <div class="site-footer__grid">

            <div class="site-footer__brand">
                Logo / Business
            </div>

            <nav class="site-footer__nav">
                <a href="#">Home</a>
                <a href="#">Services</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </nav>

            <div class="site-footer__contact">
                Contact placeholder
            </div>

        </div>


        <div class="site-footer__bottom">
            Copyright Placeholder
        </div>

    </div>

</footer>

@endsection
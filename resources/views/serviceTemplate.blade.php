@extends('layouts.app')

@section('title', 'Service | Michael\'s Tech Repair')

@section('content')

<main class="service-page">

    {{-- ======================================
        SERVICE HERO
    ======================================= --}}
    <section class="service-hero">

        <div class="page-container">

            <div class="service-hero__content">

                <span class="service-hero__eyebrow">
                    Service
                </span>

                <h1 class="service-hero__title">
                    Service Name
                </h1>

                <p class="service-hero__description">
                    Placeholder service description.
                </p>


                <div class="service-hero__actions">

                    <a
                        href="#"
                        class="button button--primary"
                    >
                        Request Help
                    </a>

                    <a
                        href="#"
                        class="button button--secondary"
                    >
                        Contact Me
                    </a>

                </div>


                <div class="service-hero__meta">
                    Placeholder • Placeholder • Placeholder
                </div>

            </div>

        </div>

    </section>



    {{-- ======================================
        COMMON PROBLEMS
    ======================================= --}}
    <section class="section service-problems">

        <div class="page-container">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    Common Issues
                </span>

                <h2 class="section-heading__title">
                    Problems I Can Help With
                </h2>

            </header>


            <div class="service-problem-grid">

                @for ($i = 1; $i <= 6; $i++)

                    <article class="service-problem-card">

                        <div class="placeholder placeholder--icon">
                            Icon
                        </div>

                        <h3>
                            Problem {{ $i }}
                        </h3>

                        <p>
                            Placeholder description.
                        </p>

                    </article>

                @endfor

            </div>

        </div>

    </section>



    {{-- ======================================
        SERVICE DETAILS
    ======================================= --}}
    <section class="section service-details">

        <div class="page-container">

            <div class="service-details__grid">

                <div class="service-details__content">

                    <span class="section-heading__eyebrow">
                        Service Details
                    </span>

                    <h2>
                        What's Included
                    </h2>


                    <ul class="service-checklist">

                        @for ($i = 1; $i <= 8; $i++)

                            <li>
                                Placeholder service item
                            </li>

                        @endfor

                    </ul>

                </div>


                <div class="service-details__media">

                    <div class="placeholder placeholder--image">
                        Service Image
                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ======================================
        PROCESS
    ======================================= --}}
    <section class="section service-process">

        <div class="page-container">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    Process
                </span>

                <h2>
                    How It Works
                </h2>

            </header>


            <div class="process-grid">

                @for ($i = 1; $i <= 4; $i++)

                    <article class="process-step">

                        <div class="process-step__number">
                            {{ $i }}
                        </div>

                        <h3>
                            Step {{ $i }}
                        </h3>

                        <p>
                            Placeholder description.
                        </p>

                    </article>

                @endfor

            </div>

        </div>

    </section>



    {{-- ======================================
        PRICING / FAQ
    ======================================= --}}
    <section class="section service-info">

        <div class="page-container">

            <div class="service-info__grid">

                <section class="service-pricing">

                    <h2>
                        Pricing
                    </h2>

                    @for ($i = 1; $i <= 3; $i++)

                        <div class="pricing-row">

                            <span>
                                Placeholder
                            </span>

                            <span>
                                $XX
                            </span>

                        </div>

                    @endfor

                </section>


                <section class="service-faq">

                    <h2>
                        FAQ
                    </h2>

                    @for ($i = 1; $i <= 5; $i++)

                        <details class="faq-item">

                            <summary>
                                Question {{ $i }}
                            </summary>

                            <p>
                                Placeholder answer.
                            </p>

                        </details>

                    @endfor

                </section>

            </div>

        </div>

    </section>



    {{-- ======================================
        FINAL CTA
    ======================================= --}}
    <section class="section service-contact">

        <div class="page-container">

            <div class="service-contact__content">

                <h2>
                    Need Help?
                </h2>

                <p>
                    Placeholder contact text.
                </p>


                <div class="service-contact__actions">

                    <a
                        href="#"
                        class="button button--primary"
                    >
                        Contact Form
                    </a>

                    <a
                        href="#"
                        class="button button--secondary"
                    >
                        Email
                    </a>

                </div>

            </div>

        </div>

    </section>

</main>

@endsection
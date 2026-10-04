// resources/views/serviceTemplate.blade.php
@extends('layouts.app')

@section('title', ($title ?? 'Service') . " | Michael's Tech Repair")

@section('content')

<main class="service-page">

    {{-- ======================================
        SERVICE SECTION
    ======================================= --}}
    <section class="service-hero">

        <div class="page-container">

            <div class="service-hero__content">

                <span class="service-hero__eyebrow">
                    {{ $eyebrow ?? 'Service' }}
                </span>

                <h1 class="service-hero__title">
                    {{ $title ?? 'Service Name' }}
                </h1>

                <p class="service-hero__description">
                    {{ $description ?? 'Service description goes here.' }}
                </p>

                <div class="service-hero__actions">

                    <a
                        href="{{ route('home') }}#services"
                        class="button button--primary"
                    >
                        Other Services
                    </a>

                    <a
                        href="/contact"
                        class="button button--secondary"
                    >
                        Contact Me
                    </a>

                </div>

                @if (!empty($meta))

                    <div class="service-hero__meta">
                        {{ $meta }}
                    </div>

                @endif

            </div>

        </div>

    </section>


    {{-- ======================================
        COMMON PROBLEMS
    ======================================= --}}
    @if (!empty($problems))

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

                    @foreach ($problems as $problem)

                        <article class="service-problem-card">

                            <div class="placeholder placeholder--icon">
                                {{ $problem['icon'] ?? 'Icon' }}
                            </div>

                            <h3>
                                {{ $problem['title'] }}
                            </h3>

                            <p>
                                {{ $problem['description'] }}
                            </p>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- ======================================
        SERVICE DETAILS
    ======================================= --}}
    @if (!empty($included))

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

                            @foreach ($included as $item)

                                <li>
                                    {{ $item }}
                                </li>

                            @endforeach

                        </ul>

                    </div>


                    <div class="service-details__media">

                        <div class="placeholder placeholder--image">
                            {{ $imageLabel ?? 'Service Image' }}
                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- ======================================
        PROCESS
    ======================================= --}}
    @if (!empty($process))

        <section class="section service-process">

            <div class="page-container">

                <header class="section-heading">

                    <span class="section-heading__eyebrow">
                        Process
                    </span>

                    <h2 class="section-heading__title">
                        How It Works
                    </h2>

                </header>


                <div class="process-grid">

                    @foreach ($process as $index => $step)

                        <article class="process-step">

                            <div class="process-step__number">
                                {{ $index + 1 }}
                            </div>

                            <h3>
                                {{ $step['title'] }}
                            </h3>

                            <p>
                                {{ $step['description'] }}
                            </p>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- ======================================
        PRICING / FAQ
    ======================================= --}}
    @if (!empty($pricing) || !empty($faq))

        <section class="section service-info">

            <div class="page-container">

                <div class="service-info__grid">

                    @if (!empty($pricing))

                        <section class="service-pricing">

                            <h2>
                                Pricing
                            </h2>

                            @foreach ($pricing as $price)

                                <div class="pricing-row">

                                    <span>
                                        {{ $price['name'] }}
                                    </span>

                                    <span>
                                        {{ $price['price'] }}
                                    </span>

                                </div>

                            @endforeach

                        </section>

                    @endif


                    @if (!empty($faq))

                        <section class="service-faq">

                            <h2>
                                FAQ
                            </h2>

                            @foreach ($faq as $item)

                                <details class="faq-item">

                                    <summary>
                                        {{ $item['question'] }}
                                    </summary>

                                    <p>
                                        {{ $item['answer'] }}
                                    </p>

                                </details>

                            @endforeach

                        </section>

                    @endif

                </div>

            </div>

        </section>

    @endif


    {{-- ======================================
        FINAL CTA
    ======================================= --}}
    <section class="section service-contact">

        <div class="page-container">

            <div class="service-contact__content">

                <h2>
                    {{ $ctaTitle ?? 'Need Help?' }}
                </h2>

                <p>
                    {{ $ctaText ?? 'Tell me what you are dealing with and I can help figure out the next step.' }}
                </p>


                <div class="service-contact__actions">

                    <a
                        href="/contact"
                        class="button button--primary"
                    >
                        Contact Form
                    </a>

                    <a
                        href="{{ route('home') }}#services"
                        class="button button--secondary"
                    >
                        View Other Services
                    </a>

                </div>

            </div>

        </div>

    </section>

</main>


@include('layouts.footer')

@endsection

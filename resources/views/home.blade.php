@extends('layouts.app')

@section('title', "Home | Michael's Tech Repair")

@section('content')

<main class="home">
@include('layouts.header')
    {{-- =====================================================
        SERVICES
    ====================================================== --}}
    <section class="section services" id="services">

        <div class="page-container">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    Services
                </span>

                <h2 class="section-heading__title">
                    How I Can Help
                </h2>

            </header>


            @php

                $services = [
                    [
                        'icon' => 'computer-repair.png',
                        'title' => 'Computer Repair',
                        'description' => 'Diagnosis, repair, and maintenance for desktop and laptop computers.',
                        'url' => route('services.computer-repair'),
                    ],[
                        'icon' => 'virus-removal.png',
                        'title' => 'Virus Removal',
                        'description' => 'Removal of malware, unwanted software, and other security threats.',
                        'url' => route('services.virus-removal'),
                    ],[
                        'icon' => 'home-tech.png',
                        'title' => 'Home Tech Setup',
                        'description' => 'Assistance setting up everyday technology around your home.',
                        'url' => route('services.home-tech-setup'),
                    ],[
                        'icon' => 'troubleshooting-devices.png',
                        'title' => 'Troubleshooting Devices',
                        'description' => 'Help resolving technical issues with computers and connected devices.',
                        'url' => route('services.device-troubleshooting'),
                    ],[
                        'icon' => 'website-creation.png',
                        'title' => 'Website Creation & Maintenance',
                        'description' => 'Custom websites, hosting setup, updates, and ongoing maintenance.',
                        'url' => route('services.website-creation'),
                    ],[
                        'icon' => 'pc-builds.png',
                        'title' => 'PC Builds & Upgrades',
                        'description' => 'Custom computer builds, component selection, and hardware upgrades.',
                        'url' => route('services.pc-builds'),
                    ],[
                        'icon' => 'media-server-setup.png',
                        'title' => 'Media Server Setup',
                        'description' => 'Personal media servers, streaming configuration, and home entertainment.',
                        'url' => route('services.media-servers'),
                    ],[
                        'icon' => 'network-setup.png',
                        'title' => 'Network Setup',
                        'description' => 'Wi-Fi, routers, Ethernet, network configuration, and troubleshooting.',
                        'url' => route('services.network-setup'),
                    ],[
                        'icon' => 'cloud-server-administration.png',
                        'title' => 'Cloud & Server Administration',
                        'description' => 'Linux servers, Docker, hosting, deployment, and cloud infrastructure.',
                        'url' => route('services.cloud-server-administration'),
                    ],
                ];

            @endphp


            <div class="service-grid">
            
                @foreach ($services as $service)
            
                    <a
                        href="{{ $service['url'] }}"
                        class="service-card"
                        aria-label="Learn more about {{ $service['title'] }}"
                    >
            
                        <div class="service-card__icon">
                        
                            <img
                                src="{{ asset('images/icons/' . $service['icon']) }}"
                                alt=""
                                width="150"
                                height="150"
                                loading="lazy"
                            >
                        
                        </div>
                    
                        <h3 class="service-card__title">
                            {{ $service['title'] }}
                        </h3>
                    
                        <span class="service-card__link">
                            Learn More &rarr;
                        </span>
                    
                    </a>
                
                @endforeach
                
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
@include('layouts.footer')
@endsection


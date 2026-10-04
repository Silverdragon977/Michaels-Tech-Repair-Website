{{-- resources/views/home.blade.php --}}
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


        </div>

    </section>


{{-- ==========================================
    BENEFITS
=========================================== --}}

@php
    $benefits = [
        [
            'title' => 'Clear Explanations',
            'description' =>
                'Understand what is happening with your technology and what your available options are.',
            'icon' => 'messages-square',
        ],

        [
            'title' => 'Transparent Pricing',
            'description' =>
                'Review the expected cost and scope of work before proceeding with a service.',
            'icon' => 'wallet',
        ],

        [
            'title' => 'Flexible Service Options',
            'description' =>
                'Depending on the issue, arrange an on-site appointment, device drop-off, or remote assistance.',
            'icon' => 'house',
        ],

        [
            'title' => 'Personalized Support',
            'description' =>
                'Work directly with the person responsible for diagnosing and handling your technology problem.',
            'icon' => 'user-round',
        ],

        [
            'title' => 'Everyday & Advanced IT',
            'description' =>
                'From setting up a printer to configuring servers, networks, and websites.',
            'icon' => 'server-cog',
        ],
    ];
@endphp


<section class="section benefits">

    <div class="page-container">

        <header class="section-heading">

            <span class="section-heading__eyebrow">
                Why Work With Me
            </span>

            <h2 class="section-heading__title">
                Why Choose Michael's Tech Repair?
            </h2>

        </header>


        <div class="benefit-grid">

            @foreach ($benefits as $benefit)

                <article class="benefit">

                    <h3 class="benefit__title">
                        {{ $benefit['title'] }}
                    </h3>

                    <p class="benefit__description">
                        {{ $benefit['description'] }}
                    </p>

                </article>

            @endforeach

        </div>

    </div>

</section>


    {{-- =====================================================
        CONTACT CTA
    ====================================================== --}}
    <aside class="problem-cta">
    
        <div class="problem-cta__content">
        
            <h3>Not Sure What Service You Need?</h3>
        
            <p>
                Describe what's happening or what you're trying to accomplish.
                You don't need to diagnose the problem yourself.
            </p>
        
        </div>
    
        <div class="problem-cta__action">
        
            <a href="{{ route('contact') }}" class="button button--primary">
                Get Help
            </a>
        
        </div>
    
    </aside>

</main>
@include('layouts.footer')
@endsection


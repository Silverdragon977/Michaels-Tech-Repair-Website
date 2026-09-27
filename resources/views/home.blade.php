@extends('bladeTemplate')


@section('title', "Michael's Tech Repair")


@section('content')


 <main class="home-page">

        <section class="hero">

            <div class="hero__content">

                <p class="hero__eyebrow">
                    Local Tech Help • Web Development • Cloud
                </p>

                <h1 class="hero__title">
                    Technology that works for you.
                </h1>

                <p class="hero__description">
                    Michaels Tech Repair provides practical computer help,
                    modern website development, PC upgrades, and cloud
                    solutions without unnecessary complexity.
                </p>

                <div class="hero__actions">

                    <a
                        href="#services"
                        class="button button--primary"
                    >
                        View Services
                    </a>

                    <a
                        href="#contact"
                        class="button button--secondary"
                    >
                        Contact Me
                    </a>

                </div>

            </div>

        </section>


        <section
            id="services"
            class="services"
        >

            <div class="section-heading">

                <p class="section-heading__eyebrow">
                    Services
                </p>

                <h2>
                    Practical solutions for home and business technology.
                </h2>

            </div>


            <div class="service-grid">

                <article class="service-card">

                    <h3>
                        Website Creation & Setup
                    </h3>

                    <p>
                        Modern websites built with maintainable tools,
                        responsive layouts, and reliable deployment.
                    </p>

                </article>


                <article class="service-card">

                    <h3>
                        Cloud & DevOps
                    </h3>

                    <p>
                        Docker, Linux servers, cloud hosting, deployment
                        automation, and infrastructure setup.
                    </p>

                </article>


                <article class="service-card">

                    <h3>
                        PC Builds & Upgrades
                    </h3>

                    <p>
                        Hardware upgrades, custom PC builds, troubleshooting,
                        and practical recommendations.
                    </p>

                </article>

            </div>

        </section>


        <section class="react-section">

            <div class="section-heading">

                <p class="section-heading__eyebrow">
                    Laravel + React
                </p>

                <h2>
                    Application test component
                </h2>

                <p>
                    This component verifies that React is mounting correctly
                    inside the Laravel Blade application.
                </p>

            </div>


            <div id="react-demo"></div>

        </section>


        <section
            id="contact"
            class="contact"
        >

            <div>

                <p class="section-heading__eyebrow">
                    Need help?
                </p>

                <h2>
                    Let's find a practical solution.
                </h2>

            </div>


            <a
                href="mailto:michaelhoward977@gmail.com"
                class="button button--primary"
            >
                Get in Touch
            </a>

        </section>

    </main>


@endsection

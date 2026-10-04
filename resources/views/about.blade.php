@extends('layouts.app')

@section('title', "About | Michael's Tech Repair")

@section('content')

<main class="about-page">

    {{-- INTRODUCTION --}}
    <section class="section about-hero">
        <div class="page-container">

            <span class="section-heading__eyebrow">
                About the Business
            </span>

            <h1 class="about-hero__title">
                Hi, I'm Michael.
            </h1>

            <p class="about-hero__lead">
                I started Michael's Tech Repair to help people
                solve everyday technology problems while also
                offering more advanced technical services.
            </p>

            <p>
                Whether you're dealing with a frustrating computer
                problem, setting up technology around your home,
                or planning a website or server project, my goal
                is to make the process easier to understand.
            </p>

        </div>
    </section>


    {{-- BACKGROUND --}}
    <section class="section about-background">
        <div class="page-container">

            <header class="section-heading">
                <span class="section-heading__eyebrow">
                    My Background
                </span>

                <h2 class="section-heading__title">
                    Practical Experience Across Technology
                </h2>
            </header>

            <p>
                My background includes computer science, software
                development, computer hardware, networking, and
                Linux server administration.
            </p>

            <p>
                I've worked on projects involving custom web
                applications, database systems, Docker containers,
                cloud hosting, network configuration, and
                automated software deployment.
            </p>

            <p>
                I enjoy both sides of technology: solving the
                everyday problems that make devices frustrating
                to use and building the systems that keep
                applications and services running.
            </p>

        </div>
    </section>


    {{-- APPROACH --}}
    <section class="section about-approach">
        <div class="page-container">

            <header class="section-heading">
                <span class="section-heading__eyebrow">
                    My Approach
                </span>

                <h2 class="section-heading__title">
                    Technology Should Work for You
                </h2>
            </header>

            <div class="about-principles">

                <article class="about-principle">
                    <h3>Understand the Problem</h3>

                    <p>
                        Start by identifying what's happening and
                        understanding what you need to accomplish.
                    </p>
                </article>

                <article class="about-principle">
                    <h3>Explain Your Options</h3>

                    <p>
                        Discuss practical solutions in understandable
                        terms, without unnecessary technical jargon.
                    </p>
                </article>

                <article class="about-principle">
                    <h3>Find the Right Solution</h3>

                    <p>
                        Focus on a solution that fits the actual
                        problem rather than recommending unnecessary
                        products or services.
                    </p>
                </article>

            </div>

        </div>
    </section>


    {{-- CONTACT --}}
    <section class="section about-contact">
        <div class="page-container">

            <h2>Have a Project or Technical Problem?</h2>

            <p>
                Tell me a little about what you're looking for,
                and we can discuss the next steps.
            </p>

            <a
                href="{{ route('contact') }}"
                class="button button--primary"
            >
                Get in Touch
            </a>

        </div>
    </section>

</main>

@include('layouts.footer')

@endsection
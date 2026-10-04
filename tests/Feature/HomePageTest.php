{{-- tests/Feature/HomePageTest.php --}}

<?php

beforeEach(function () {
    $this->withoutVite();
});

test('home page loads successfully', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee("Michael's Tech Repair");
});

test('home page displays all nine services', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder([
            'Computer Repair',
            'Virus Removal',
            'Home Tech Setup',
            'Troubleshooting Devices',
            'Website Creation &amp; Maintenance',
            'PC Builds &amp; Upgrades',
            'Media Server Setup',
            'Network Setup',
            'Cloud &amp; Server Administration',
        ], false);
});

test('home page service cards link to their correct routes', function () {
    $response = $this->get(route('home'))->assertOk();

    $routes = [
        'services.computer-repair',
        'services.virus-removal',
        'services.home-tech-setup',
        'services.device-troubleshooting',
        'services.website-creation',
        'services.pc-builds',
        'services.media-servers',
        'services.network-setup',
        'services.cloud-server-administration',
    ];

    foreach ($routes as $name) {
        $response->assertSee('href="'.route($name).'"', false);
    }
});

test('homepage offers exactly one service assistance CTA', function () {
    $response = $this->get(route('home'))->assertOk();

    $response
        ->assertSee('Not Sure What Service You Need?')
        ->assertSee('href="'.route('contact').'"', false)
        ->assertDontSee('Placeholder CTA Heading')
        ->assertDontSee('Placeholder CTA text.');

    expect(substr_count(
        $response->getContent(),
        'class="problem-cta"'
    ))->toBe(1);
});

test('home page displays all five benefits', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Clear Explanations')
        ->assertSee('Transparent Pricing')
        ->assertSee('Flexible Service Options')
        ->assertSee('Personalized Support')
        ->assertSee('Everyday &amp; Advanced IT', false);
});
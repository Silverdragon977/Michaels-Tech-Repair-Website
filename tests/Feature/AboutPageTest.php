<?php

beforeEach(function () {
    $this->withoutVite();
});

test('about page loads successfully', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee("Hi, I'm Michael.", false)
        ->assertSee('Practical Experience Across Technology');
});

test('about page explains the service approach', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Understand the Problem')
        ->assertSee('Explain Your Options')
        ->assertSee('Find the Right Solution');
});

test('about page links to the dedicated contact page', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('href="'.route('contact').'"', false)
        ->assertSee('Get in Touch');
});

test('about page does not contain its original placeholder', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertDontSee('More information about my background');
});
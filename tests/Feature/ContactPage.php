<?php

beforeEach(function () {
    $this->withoutVite();
});

test('contact page loads successfully', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee("Let's Get Your Technology Working.", false);
});

test('contact page has a service request form', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('action="'.route('contact.store').'"', false)
        ->assertSee('Send a Message')
        ->assertSee('Send Message')
        ->assertSee('name="_token"', false);
});

test('contact page displays the direct business email', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('contact@michaelstechrepair.com')
        ->assertSee('Copy Email Address');
});

test('contact page includes clipboard interaction markup', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('id="copy-business-email"', false)
        ->assertSee('aria-live="polite"', false);
});

test('contact page does not contain its original placeholder', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertDontSee(
            'Contact information and a request form will be available here.'
        );
});
<?php

use App\Mail\ContactInquiry;

function exampleInquiry(): ContactInquiry
{
    return new ContactInquiry([
        'name' => 'Jane Example',
        'email' => 'jane@example.com',
        'phone' => '+12025550148',
        'service' => 'computer-repair',
        'message' => 'My computer occasionally shuts down unexpectedly.',
    ]);
}

test('contact inquiry renders a branded email', function () {

    $html = exampleInquiry()->render();

    expect($html)
        ->toContain("MICHAEL'S TECH REPAIR")
        ->toContain('New Customer Inquiry')
        ->toContain('Jane Example')
        ->toContain('Computer Repair')
        ->toContain('Reply to Customer');

});

test('customer supplied HTML is escaped in the notification', function () {

    $mail = new ContactInquiry([
        'name' => 'Jane Example',
        'email' => 'jane@example.com',
        'phone' => null,
        'service' => 'other',
        'message' => '<script>alert("test")</script>',
    ]);

    $html = $mail->render();

    expect($html)
        ->not->toContain('<script>')
        ->toContain('&lt;script&gt;');

});
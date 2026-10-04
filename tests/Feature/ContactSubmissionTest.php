<?php

use App\Mail\ContactInquiry;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->withoutVite();

    Mail::fake();
});

function validContactDetails(): array
{
    return [
        'name' => 'Test Customer',
        'email' => 'customer@example.com',
        'phone' => '',
        'service' => 'computer-repair',
        'message' => 'My computer is having trouble starting properly.',
        'website' => '',
    ];
}

test('a valid inquiry is accepted', function () {
    $this->post(route('contact.store'), validContactDetails())
        ->assertRedirect(route('contact'))
        ->assertSessionHas('contact_success');

    Mail::assertSent(ContactInquiry::class, 1);
});

test('invalid contact information is rejected', function () {
    $details = validContactDetails();

    $details['email'] = 'not-an-email';
    $details['message'] = 'Too short';

    $this->post(route('contact.store'), $details)
        ->assertSessionHasErrors(['email', 'message']);

    Mail::assertNothingSent();
});

test('an invalid service category is rejected', function () {
    $details = validContactDetails();

    $details['service'] = 'invalid-service';

    $this->post(route('contact.store'), $details)
        ->assertSessionHasErrors('service');

    Mail::assertNothingSent();
});

test('a filled honeypot is rejected', function () {
    $details = validContactDetails();

    $details['website'] = 'https://spam.example';

    $this->post(route('contact.store'), $details)
        ->assertSessionHasErrors('website');

    Mail::assertNothingSent();
});

test('an inquiry is addressed to the configured business inbox', function () {
    config()->set(
        'mail.contact_recipient',
        'business@example.com'
    );

    $this->post(route('contact.store'), validContactDetails())
        ->assertRedirect(route('contact'));

    Mail::assertSent(ContactInquiry::class, function ($mail) {
        return $mail->hasTo('business@example.com')
            && $mail->details['email'] === 'customer@example.com';
    });
});

test('the inquiry uses the customer as its reply-to address', function () {
    $this->post(route('contact.store'), validContactDetails());

    Mail::assertSent(ContactInquiry::class, function ($mail) {
        $replyTo = $mail->envelope()->replyTo;

        return count($replyTo) === 1
            && $replyTo[0]->address === 'customer@example.com';
    });
});
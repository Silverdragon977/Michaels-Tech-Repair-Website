<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $details = $request->safe()->only([
            'name',
            'email',
            'phone',
            'service',
            'message',
        ]);

        try {
            Mail::to(config('mail.contact_recipient'))
                ->send(new ContactInquiry($details));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'contact' => 'Your message could not be sent. Please try again or contact me directly using the email address shown here.',
                ]);
        }

        return redirect()
            ->route('contact')
            ->with('contact_success', 'Your message has been sent. Thank you for reaching out!');
    }
}
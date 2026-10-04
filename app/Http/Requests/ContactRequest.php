<?php
// app/Http/Requests/ContactRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => [
                'required',
                'in:computer-repair,virus-removal,home-tech-setup,device-troubleshooting,website-creation,pc-builds,media-servers,network-setup,cloud-server,other',
            ],
            'message' => ['required', 'string', 'min:15', 'max:5000'],

            // A field ordinary visitors should never fill.
            'website' => ['prohibited'],
        ];
    }
}
{{-- resources/views/emails/contact-inquiry.blade.php --}}

@extends('emails.layouts.notification')

@section('email_title', 'New Customer Inquiry')

@section('email_category', 'WEBSITE NOTIFICATION')

@section('footer_note', 'This message contains customer-submitted information. Handle confidentially.')

@section('content')

@php
    $serviceNames = [
        'computer-repair' => 'Computer Repair',
        'virus-removal' => 'Virus Removal',
        'home-tech-setup' => 'Home Tech Setup',
        'device-troubleshooting' => 'Device Troubleshooting',
        'website-creation' => 'Website Creation & Maintenance',
        'pc-builds' => 'PC Builds & Upgrades',
        'media-servers' => 'Media Server Setup',
        'network-setup' => 'Network Setup',
        'cloud-server-administration' => 'Cloud & Server Administration',
        'other' => 'Other / Not Sure',
    ];

    $serviceName = $serviceNames[$details['service']] ?? 'General Inquiry';

    $customerPhone = $details['phone'] ?: 'Not provided';

    $replyAddress = $details['email'];
@endphp


{{-- TITLE --}}

<h1
    style="
        margin: 0 0 12px;
        color: #f5f7fb;
        font-size: 27px;
        line-height: 1.3;
        font-weight: bold;
    "
>
    New Customer Inquiry
</h1>

<p
    style="
        margin: 0 0 28px;
        color: #b8c3d9;
        font-size: 15px;
        line-height: 1.7;
    "
>
    Someone has submitted a new service request through
    your website. Their information is provided below.
</p>


{{-- CUSTOMER INFORMATION --}}

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        background-color: #08111f;
        border: 1px solid #26364e;
    "
>

    <tr>
        <td
            colspan="2"
            style="
                padding: 20px 20px 12px;
                color: #72d6b0;
                font-size: 11px;
                font-weight: bold;
                letter-spacing: 1.5px;
            "
        >
            CUSTOMER INFORMATION
        </td>
    </tr>

    <tr>
        <td
            width="110"
            style="
                padding: 10px 12px 10px 20px;
                color: #b8c3d9;
                font-size: 13px;
            "
        >
            Name
        </td>

        <td
            style="
                padding: 10px 20px 10px 0;
                color: #f5f7fb;
                font-size: 14px;
                font-weight: bold;
                overflow-wrap: anywhere;
            "
        >
            {{ $details['name'] }}
        </td>
    </tr>

    <tr>
        <td
            style="
                padding: 10px 12px 10px 20px;
                color: #b8c3d9;
                font-size: 13px;
            "
        >
            Email
        </td>

        <td
            style="
                padding: 10px 20px 10px 0;
                font-size: 14px;
                overflow-wrap: anywhere;
            "
        >
            <a
                href="mailto:{{ $replyAddress }}"
                style="
                    color: #72d6b0;
                    text-decoration: none;
                "
            >
                {{ $replyAddress }}
            </a>
        </td>
    </tr>

    <tr>
        <td
            style="
                padding: 10px 12px 10px 20px;
                color: #b8c3d9;
                font-size: 13px;
            "
        >
            Phone
        </td>

        <td
            style="
                padding: 10px 20px 10px 0;
                color: #f5f7fb;
                font-size: 14px;
            "
        >
            {{ $customerPhone }}
        </td>
    </tr>

    <tr>
        <td
            style="
                padding: 10px 12px 20px 20px;
                color: #b8c3d9;
                font-size: 13px;
            "
        >
            Service
        </td>

        <td
            style="
                padding: 10px 20px 20px 0;
                color: #72d6b0;
                font-size: 14px;
                font-weight: bold;
            "
        >
            {{ $serviceName }}
        </td>
    </tr>

</table>


{{-- CUSTOMER MESSAGE --}}

<h2
    style="
        margin: 30px 0 12px;
        color: #72d6b0;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1.5px;
    "
>
    CUSTOMER MESSAGE
</h2>

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        background-color: #08111f;
        border: 1px solid #26364e;
    "
>
    <tr>
        <td
            style="
                padding: 20px;
                color: #f5f7fb;
                font-size: 14px;
                line-height: 1.8;
                white-space: pre-wrap;
                overflow-wrap: anywhere;
            "
        >{{ $details['message'] }}</td>
    </tr>
</table>


{{-- REPLY BUTTON --}}

<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    border="0"
    align="center"
    style="margin: 30px auto 0;"
>
    <tr>
        <td
            align="center"
            bgcolor="#72d6b0"
            style="
                background-color: #72d6b0;
                border-radius: 8px;
            "
        >

            <a
                href="mailto:{{ $replyAddress }}?subject={{ rawurlencode("Re: Your Michael's Tech Repair Inquiry") }}"
                style="
                    display: inline-block;
                    padding: 14px 26px;
                    color: #07111a;
                    font-size: 14px;
                    font-weight: bold;
                    text-decoration: none;
                "
            >
                Reply to Customer
            </a>

        </td>
    </tr>
</table>

<p
    style="
        margin: 18px 0 0;
        color: #7a879c;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
    "
>
    This shortcut opens your default email application.
    You can also use Reply in your email client.
</p>

@endsection
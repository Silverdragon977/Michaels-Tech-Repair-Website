{{-- resources/views/emails/layouts/notification.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="color-scheme" content="light dark">

    <title>
        @yield('email_title', "Michael's Tech Repair")
    </title>
</head>

<body
    style="
        margin: 0;
        padding: 0;
        background-color: #05070d;
        color: #f5f7fb;
        font-family: Arial, Helvetica, sans-serif;
        -webkit-text-size-adjust: 100%;
    "
>

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background-color: #05070d;"
>
    <tr>
        <td
            align="center"
            style="padding: 32px 12px;"
        >

            {{-- MAIN EMAIL CONTAINER --}}

            <table
                role="presentation"
                width="600"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    width: 100%;
                    max-width: 600px;
                    background-color: #111a2d;
                    border: 1px solid #26364e;
                    border-collapse: separate;
                    border-spacing: 0;
                "
            >

                {{-- HEADER --}}

                <tr>
                    <td
                        style="
                            padding: 30px 32px;
                            background-color: #08111f;
                            border-bottom: 3px solid #72d6b0;
                        "
                    >

                        <p
                            style="
                                margin: 0 0 6px;
                                color: #f5f7fb;
                                font-size: 19px;
                                font-weight: bold;
                                letter-spacing: 0.4px;
                            "
                        >
                            MICHAEL'S TECH REPAIR
                        </p>

                        <p
                            style="
                                margin: 0;
                                color: #72d6b0;
                                font-size: 11px;
                                font-weight: bold;
                                letter-spacing: 2px;
                            "
                        >
                            @yield('email_category', 'BUSINESS COMMUNICATION')
                        </p>

                    </td>
                </tr>


                {{-- EMAIL CONTENT --}}

                <tr>
                    <td style="padding: 32px;">

                        @yield('content')

                    </td>
                </tr>


                {{-- FOOTER --}}

                <tr>
                    <td
                        align="center"
                        style="
                            padding: 24px 32px;
                            background-color: #08111f;
                            border-top: 1px solid #26364e;
                        "
                    >

                        <p
                            style="
                                margin: 0 0 8px;
                                color: #b8c3d9;
                                font-size: 12px;
                                line-height: 1.6;
                            "
                        >
                            Michael's Tech Repair
                        </p>

                        <p
                            style="
                                margin: 0;
                                font-size: 12px;
                            "
                        >
                            <a
                                href="https://michaelstechrepair.com"
                                style="
                                    color: #72d6b0;
                                    text-decoration: none;
                                "
                            >
                                michaelstechrepair.com
                            </a>
                        </p>

                        <p
                            style="
                                margin: 12px 0 0;
                                color: #7a879c;
                                font-size: 11px;
                                line-height: 1.6;
                            "
                        >
                            @yield('footer_note',
                                "An automated message from Michael's Tech Repair."
                            )
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
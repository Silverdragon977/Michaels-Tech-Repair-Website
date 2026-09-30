<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', "Michael's Tech Repair")
    </title>

    @vite([
        'resources/scss/app.scss',
        'resources/js/app.tsx'
    ])
</head>

<body>

    @yield('content')

</body>
</html>
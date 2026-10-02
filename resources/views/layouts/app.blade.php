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
    @viteReactRefresh
    @vite([
        'resources/scss/app.scss',
        'resources/js/app.tsx'
    ])
</head>

<body>
    @include('layouts.navigation')
    @yield('header')
    @yield('content')
    @yield('footer')

</body>
</html>
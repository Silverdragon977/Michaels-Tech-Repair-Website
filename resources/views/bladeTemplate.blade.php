<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>
        @yield('title', config('app.name'))
    </title>


    @viteReactRefresh


    @vite([
        'resources/scss/app.scss',
        'resources/js/app.tsx'
    ])

</head>


<body>


    <header>

        <div class="container">

            <h1>
                {{ config('app.name') }}
            </h1>

        </div>

    </header>


    <main class="container">


        @yield('content')


        {{--
            Example React mount point.

            React will find this element from:

                resources/js/app.tsx

            and mount ReactDemo into it.
        --}}

        <div id="react-demo"></div>


    </main>


</body>

</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        @section('stylesheets')
        @show
    </head>
    <body>
        @include('navbar')

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
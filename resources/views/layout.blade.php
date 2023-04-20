<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @section('ajax')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    
    @show
    @section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/taula.css') }}" />
    @show
</head>

<body>
    @include('navbar')

    <div class="container">
        @yield('content')
    </div>
</body>

</html>
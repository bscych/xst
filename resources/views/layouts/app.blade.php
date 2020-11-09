<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @auth
        <x-displayer/>@
        @endauth
        {{ config('app.name', '小书童') }}
    
    </title>
    
    <!-- Scripts -->
    @section('script')
    <script src="{{ asset('js/app.js') }}" defer></script>
   @show
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset('/imgs/logo20.png')}}"  mce_href="{{asset('/imgs/logo20.png')}}" type="image/x-icon">
</head>
<body>
    <div id="app">
         @component('layouts.nav')
        @endcomponent
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

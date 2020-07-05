<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app1.js') }}" ></script>
    <script src="https://use.fontawesome.com/e21f027b5f.js"></script>
    @yield('content_scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app1.css') }}" rel="stylesheet">
    @yield('content_styles')

</head>
<body>
    <div id="app">
        @include('layouts.navigation.topmenu')
 
        <main class="py-4">
            
            @if(Session::has('flash_message'))
    
            <div class="container">
            <div class="panel panel-default">
            <div class="panel-heading">
            <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
            </div>
            </div>
            </div>
            </div>
            @endif
            @if ($errors->any())
                <div class="container">
                <div class="panel panel-default">
                <div class="panel-heading">
                <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
                </div>
                </div>
                </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>



</body>
</html>

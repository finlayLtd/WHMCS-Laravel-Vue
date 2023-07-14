@php
    $config = [
        'appName' => config('app.name'),
        'locale' => $locale = app()->getLocale(),
        'locales' => config('app.locales'),
    ];
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CrazyRDP</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <!-- <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('assets/css/dark-theme.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet"> -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-href.png') }}">

    <!--  highcharts  -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    <!--  Select2 CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/8de0481deb.js" crossorigin="anonymous"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- Image Sprite CSS -->
    <link href="{{asset('assets/image_sprite/ip2location-image-sprite.css')}}" rel="stylesheet">

    <script>
        window.config = @json($config);
        
    </script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" id="app">
    
        <router-view></router-view>

</body>
</html>

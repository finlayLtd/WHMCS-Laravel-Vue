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

    <title>CrazyRDP | Client Panel</title>
  
    <meta content="https://my.crazyrdp.com" property="og:url">
    <meta content="en_US" property="og:locale">
    <meta content="website" property="og:type">

    <link rel="canonical" href="https://crazyrdp.com" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-href.png') }}">

    <!--  highcharts  -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    <!--  Select2 CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/8de0481deb.js" crossorigin="anonymous"></script>

    <!-- Image Sprite CSS -->
    <link href="{{asset('assets/image_sprite/ip2location-image-sprite.css')}}" rel="stylesheet">

    <script>
        window.config = @json($config);
    </script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="6c020464-0335-4950-b12c-43e8efc609fc";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
</head>
<body class="font-sans antialiased" id="app">
    <router-view></router-view>
</body>
</html>

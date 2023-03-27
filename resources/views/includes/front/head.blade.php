<head>
    <title>@yield('title') |  BK live</title>
    <!-- meta tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon-icon  -->
    <link rel="icon" href="{{URL::to('storage/app/public/Frontassets/image/favicon.ico')}}" type="image/favicon">
    <!-- font-awsome css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/css/all.min.css')}}">
    <!-- fonts css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/fonts/stylesheet.css')}}">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/css/bootstrap.min.css')}}">
    @if(Route::is('home'))
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/css/home.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/css/style.css')}}">
    @endif
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Frontassets/css/responsive.css')}}">
    @yield('css')
</head>

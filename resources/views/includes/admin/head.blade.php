<head>
    <title>@yield('title') |  BK live</title>
    <!-- meta tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon-icon  -->
    <link rel="icon" href="{{URL::to('storage/app/public/Adminassets/image/favicon.ico')}}" type="image/favicon">
    <!-- font-awsome css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/all.min.css')}}">
    <!-- fonts css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/fonts/stylesheet.css')}}">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/bootstrap.min.css')}}">
    <!-- datatables css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/dataTables.bootstrap4.min.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/responsive.bootstrap4.min.css')}}"> -->
    <!-- style css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/style.css')}}">
    <!-- responsive css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/toastr.min.css')}}">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.dev.js"></script>
    @yield('css')
</head>

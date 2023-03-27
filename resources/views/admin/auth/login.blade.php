<!DOCTYPE html>
<html>

<head>
    <title> Login | Bk Live</title>
    <!-- meta tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <!-- favicon-icon  -->
    <link rel="icon" href="{{URL::to('storage/app/public/Adminassets/image/favicon.ico')}}" type="image/favicon">
    <!-- font-awsome css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/all.min.css')}}">
    <!-- fonts css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/fonts/stylesheet.css')}}">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/bootstrap.min.css')}}">
    <!-- style css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/style.css')}}">
    <!-- responsive css  -->
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/responsive.css')}}">
    <style type="text/css">
        .invalid-feedback{
            display: block;
        }
    </style>
</head>

<body class="login-bg">


    <div class="login-screen-modal">
        <a href="javascript:void(0)" class="login-logo">
            <img src="{{URL::to('storage/app/public/Adminassets/image/logo.svg')}}" alt="" class="img-fluid">
        </a>
        <h5>WELCOME!</h5>
        <form action="{{route('admin.login')}}" method="post">
            @csrf
            <div class="login-input">
                <span>
                    <svg id="user-3-line_14_" data-name="user-3-line (14)" xmlns="http://www.w3.org/2000/svg" width="25"
                        height="25" viewBox="0 0 25 25">
                        <path id="Path_307" data-name="Path 307" d="M0,0H25V25H0Z" fill="none" />
                        <path id="Path_308" data-name="Path 308"
                            d="M21.488,23.183H19.3V21.07A3.225,3.225,0,0,0,16.023,17.9H9.465A3.225,3.225,0,0,0,6.186,21.07v2.113H4V21.07a5.376,5.376,0,0,1,5.465-5.282h6.558a5.376,5.376,0,0,1,5.465,5.282Zm-8.744-9.507A6.451,6.451,0,0,1,6.186,7.338,6.451,6.451,0,0,1,12.744,1,6.451,6.451,0,0,1,19.3,7.338,6.451,6.451,0,0,1,12.744,13.676Zm0-2.113a4.3,4.3,0,0,0,4.372-4.225,4.3,4.3,0,0,0-4.372-4.225A4.3,4.3,0,0,0,8.372,7.338,4.3,4.3,0,0,0,12.744,11.563Z"
                            transform="translate(-0.244 -0.061)" />
                    </svg>
                </span>
                <input type="text" placeholder="Email" name="email" id="email" value="{{old('email')}}">
            </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            <div class="login-input">
                <span>
                    <svg id="door-lock-line_5_" data-name="door-lock-line (5)" xmlns="http://www.w3.org/2000/svg"
                        width="25" height="25" viewBox="0 0 25 25">
                        <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                        <path id="Path_4" data-name="Path 4"
                            d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z"
                            transform="translate(-0.122 -0.122)" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" placeholder="Password">
                <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <!-- <div class="custom-control custom-checkbox login-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Accept the terms and conditions</label>
            </div> -->
            <button class="btn btn-black btn-block">LOG IN NOW</button>
        </form>
        <!-- <a href="javascirpt:void(0)" class="forgot-password">Forgot Password?</a> -->
    </div>

    <!-- bootstrap js -->
    <script src="{{URL::to('storage/app/public/Adminassets/js/jquery.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Adminassets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- custom js -->

    <script>
    $(window).on("load", function () {
      $("#spinner").fadeOut("3000");
    });

    $(document).on('click', '.toggle-password', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });
    </script>

</body>

</html>

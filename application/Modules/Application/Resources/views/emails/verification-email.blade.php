{{--<div class="hero bg-white overflow-hidden">--}}
{{--    <div class="hero-inner">--}}
{{--        <div class="content content-full text-center">--}}
{{--            <div class="block block-rounded">--}}
{{--                <div class="block-header">--}}
{{--                    <h3 class="block-title"> Welcome {{ $applicant->email }} to {{ config('app.name') }}</h3>--}}
{{--                </div>--}}
{{--                <div class="block-content block-content-full">--}}
{{--                    <p>--}}
{{--                        Click <a href=" ">this link </a> to verify your email.--}}
{{--                        To login to your username: {{ $applicant->email }}.--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('/css/oneui.css') }}">

    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
<!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/amethyst.css') }}"> -->
@yield('css_after')

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style>
        .email-container{
            height: auto !important;
            width: 50% !important;
            margin: 5% auto !important;
            border: solid goldenrod 2px !important;
            border-radius: 1% !important;
            padding: 20px !important;
        }

        .activate{
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px auto !important;
            border-radius: 4px !important;
        }
        .activate-btn{
            margin: auto !important;
            width: 40% !important;
        }
        h5{
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro" ;
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="d-flex align-middle justify-content-center">
    <div class="email-container">
        <h5>Dear Applicant</h5>
        <p>
            Welcome to <b> Technical University of Mombasa New Student Applicant Portal </b>. You are getting this email because you submitted a registration request to our system. To proceed to complete the registration process you need to confirm you email to activate your applicants account. If your account is not activated within 72hours it will lead to permanent deactivation of the account.
        </p>
        <div class="activate-btn">
            <a class="activate" href="{{ route('application.emailverification', $applicant->VerifyEmail->verification_code) }}" data-toggle="click-ripple">Activate Account</a>
        </div>
        <p>
            You can also copy and paste the following url to your browser to activate your account.<br>
            <a style="overflow-wrap: break-word !important;" href="#">
                {{ route('application.emailverification', $applicant->VerifyEmail->verification_code) }}
            </a>
        </p>
    </div>
</div>
</body>

</html>

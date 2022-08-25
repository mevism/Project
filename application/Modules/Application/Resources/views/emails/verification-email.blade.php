<div class="hero bg-white overflow-hidden">
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
{{--
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

</html> --}}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Technical  University of Mombasa</title>
        <meta name="viewport" content="width=device-width" />
       <style type="text/css">
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #27ae60; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#344a3d" style="margin: 0; padding: 0;" yahoo="fix">

        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;  " class="content">
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="color: #aaaaaa; font-family: Arial, sans-serif; font-size: 12px;">
                                  <a href="#" style="color: #27ae60; text-decoration: none;">Technical University of Mombasa</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#27ae60" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="{{ url('media/tum-logo/tum-logo.png') }}" alt="TUM" width="160" height="152" style="display:block;" />
                </td>
            </tr>
            <tr>
                <td align="auto" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                <h5>Dear Applicant</h5>
        <p>
            Welcome to Technical University of Mombasa Applicant Portal. You are getting this email because you submitted a registration request to our system. To proceed to complete the registration process you need to confirm you email to activate your applicants account. If your account is not activated within 72hours it will lead to permanent deactivation of the account.
        </p>

                </td>
            </tr>
                <tr>
                <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
                    <table bgcolor="#4CAF50" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <a type="button" data-toggle="click-ripple" href="{{ route('application.emailverification', $applicant->VerifyEmail->verification_code) }}" style="color: #ffffff; text-align: center; text-decoration: none;">Activate Account</a>
                            </td>
                        </tr>
                    </table>

                </td>

            </tr>

            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <b>Technical University of Mombasa.</b><br/>Tom Mboya street, Tudor &bull; Mombasa &bull; Kenya
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">
                                2022 &copy; <a href="http://goo.gl/TDOSuC" style="color: #27ae60;">TUM</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

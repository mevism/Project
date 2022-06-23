@extends('application::layouts.simple')

@section('content')
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('media/photos/photo28@2xjpg');">
                <div class="row g-0 bg-primary-dark-op">
                    <!-- Meta Info Section -->
                    <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                        <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <a class="link-fx fw-semibold fs-2 text-white" target="_blank" href="https://www.tum.ac.ke/">
                                    <span class="d-flex justify-content-center">
                                        <img src="{{ url('media/tum-logo/tum-logo.png') }}" alt="logo" style="width: 50% !important; height: 50% !important;">
                                    </span>
                                    <div class="h3 p-3">
                                        Technical University of Mombasa
                                    </div>
                                </a>
                                <p class="text-white-75 me-xl-8 mt-2">
                                    Welcome to Technical University of Mombasa. A Technical University of Global Excellence in Advancing Knowledge, Science and Technology.
                                </p>
                            </div>
                        </div>
                        <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                            <p class="fw-medium text-white-50 mb-0">
                                <strong>TUM</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                            <ul class="list list-inline mb-0 py-2">
                                <img src="{{ url('media/tum-logo/iso.png') }}" alt="iso image" style="height: 50px !important; width: 200px !important;">
                            </ul>
                        </div>
                    </div>
                    <!-- END Meta Info Section -->

                    <!-- Main Section -->
                    <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-light">
                        <div class="p-3 w-100 d-lg-none text-center">
                            <a class="link-fx fw-semibold fs-3 text-dark" href="https://www.tum.ac.ke/">
                                <img src="{{ url('media/tum-logo/tum-logo.png') }}" alt="logo">
                            </a>
                        </div>
                        <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <!-- Header -->
                                <div class="text-center mb-5">
                                    <h5 class="fw-bold mb-2 text-uppercase">
                                        CREATE ACCOUNT | {{ config('app.name') }}
                                    </h5>
                                    <p class="fw-medium text-muted">
                                        I already an account <a href="{{ route('root') }}"> sign in </a> here.
                                    </p>
                                </div>
                                <!-- END Header -->

                                <!-- Sign In Form -->
                                <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <div class="row g-0 justify-content-center">
                                    <div class="col-sm-8 col-xl-4">
                                        <form class="js-validation-signin" action="{{ route('application.signup') }}" method="POST">
                                            @csrf
                                            <div class="form-floating mb-4">
                                                <input type="email" class="form-control form-control-alt" value="{{ old('email') }}" name="email">
                                                <label class="form-label" for="email">Email Address</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="text" class="form-control form-control-alt" value="{{ old('mobile') }}" name="mobile">
                                                <label class="form-label" for="mobile">Mobile Number</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control form-control-alt" id="password" name="password">
                                                <label class="form-label" for="password">Create Password</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control form-control-alt" id="password_confirmation" name="password_confirmation">
                                                <label class="form-label" for="username">Password Confirmation</label>
                                            </div>
                                            <div class="captcha mb-4">
                                               <span class = "capcha_api">{!! captcha_img() !!}</span>
                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                        &#x21bb;
                                                    </button>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="text" class="form-control form-control-alt" id="captcha" name="captcha">
                                                <label class="form-label" for="captcha"> Security Captcha </label>
                                            </div>

                                            <div class="d-flex justify-content-center mb-4">
                                                <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">
                                                    Create Account
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Sign In Form -->
                            </div>
                        </div>
                        <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                            <p class="fw-medium text-white-50 mb-0">
                                <strong>TUM</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                            <ul class="list list-inline mb-0 py-2">
                                <img src="{{ url('media/tum-logo/iso.png') }}" alt="iso image" style="height: 50px !important; width: 200px !important;">
                            </ul>
                        </div>
                    </div>
                    <!-- END Main Section -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <script type="text/javascript">
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ route('application.reloadCaptcha') }}',
                success: function (data) {
                    $(".capcha_api").html(data.captcha);
                }
            });
        });
    </script>
@endsection

@extends('application::layouts.simple')
@section('content')
    <style>
        .img{
            background-image: url("/media/photos/photo33@2x.jpg");
            background-size: cover;

        }
        .block{
            background-color: rgb(0,0, 0,0.5);
        }
        .form-check-label{
            color: whitesmoke;
        }
    </style>
    <div  id="page-container">

        <!-- Main Container -->
        <main class="img" id="main-container">
            <!-- Page Content -->
            <div class="hero-static d-flex align-items-center">
                <div class="content">
                    <div class="row justify-content-center push">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <!-- Sign In Block -->
                            <div class="block block-rounded mb-0">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Applicant Portal | Phone verification </h3>
                                </div>
                                <div class="block-content">
                                    <div class="p-sm-2 px-lg-4 px-xxl-5 py-lg-4">
                                        <form class="js-validation-signin" action="{{ route('application.phoneverification') }}" method="POST">
                                            @csrf
                                            <div class="py-3">
                                                <div class="mb-4">
                                                    <input type="text" class="form-control form-control-alt form-control-lg" name="phone_number" value="{{ session('phone') }}">
                                                </div>
                                                <div class="mb-4">
                                                    <input type="text" class="form-control form-control-alt form-control-lg" name="verification_code" value="{{ session('code') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12 col-xl-12">
                                                    <button type="submit" class="btn w-100 btn-alt-primary">
                                                        <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Verify phone
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="block-options">
                                            <a class="btn-block-option fs-sm" href="#">Request code</a> | <a class="btn-block-option fs-sm" href="{{ route('root') }}">Go back</a>
                                        </div>
                                        <!-- END Sign In Form -->
                                    </div>
                                </div>
                            </div>
                            <!-- END Sign In Block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
@endsection

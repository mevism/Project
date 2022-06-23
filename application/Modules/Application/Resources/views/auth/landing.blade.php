@extends('layouts.simple')

@section('content')
    <!-- Hero -->
    <div class="hero bg-body-extra-light overflow-hidden">
        <div class="hero-inner">
            <div class="content content-full text-center">
                <div style="margin: 20px !important; padding: 7px !important;">
                    <span class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    Your phone number was successfully verified.
                </span>
                </div>
                <div>
                    A verification token was sent to your email address. Please visit your email address to activate your user account. <br>
                    All unactivated or un-updated user accounts will be permanently deleted after 72hours
                </div>
                <a class="link-fx" href="{{ route('root') }}"> I have already verified my account </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection

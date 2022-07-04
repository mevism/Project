@extends('dean::layouts.backend')
@section('content')
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('dean.applications') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Pending Applications </div>
                        <div class="fs-2 fw-normal text-dark">
                            {{ $apps }}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>
@endsection

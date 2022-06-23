@extends('layouts.backend')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('courses.review') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Reviews</div>
                        <div class="fs-2 fw-normal text-dark">
                            
                            {{-- {{ $courses }} --}}
                        </div>
                    </div>
                </a>
            </div>
          
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Notifications</div>
                        <div class="fs-2 fw-normal text-dark">9+ <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New</span> </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('courses.profile') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
            
        </div>
        <!-- END Stats -->
    </div>
    <!-- END Page Content -->
@endsection

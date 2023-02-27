@extends('lecturer::layouts.backend')
@section('content')
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Workload</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-tasks mt-2" style="font-size: 140% !important;"></i>
                            {{--                            {{ count($courses) }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">Student Marks</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-award mt-2" style="font-size: 140% !important;"></i>
                            {{--                            {{ $mycourses }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" disabled=" " href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Qualification</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                            {{--                            {{ count($notification) }} --}}
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Profile</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-user-gear mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>

@endsection

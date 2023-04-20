@extends('lecturer::layouts.backend')
@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row  align-items-sm-center">
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                     Dashboard | Lecturer
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Lecturer</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" >
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
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

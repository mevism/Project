@extends('student::layouts.backend')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row  align-items-sm-center">
            <div class="flex-grow-1">
                <h6 class="h6 fw-bold mb-0 text-uppercase">
                     Dashboard | QUICK LINKS
                </h6>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Student</a>
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
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.mycourses') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">COURSE STATUS</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-book-open-reader mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ count($courses) }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.unitregistration') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">SEMESTER REGISTRATION</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-book-journal-whills mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ $mycourses }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" disabled=" " href=" {{ route('student.feesstatement') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">FEE STATEMENT</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-coins mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ count($notification) }} --}}
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.examresults') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">EXAM RESULTS</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.myCalendar') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Academic Calender</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Help Desk</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Notifications</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">STUDENT PROFILE</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="container">
                <h6 class="h6 fw-bold mb-0 text-uppercase">Others</h6>
                <hr>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.requestacademicleave') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">APPLY DEFERMENT/LEAVES</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="{{ route('student.requestreadmission') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">APPLY READMISSION</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">APPLY SUPS/SPECIALS</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-dark border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">APPLY RETAKES</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>

@endsection

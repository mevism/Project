@extends('student::layouts.backend')

@section('content')

    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('student.mycourses') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">My Course</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-book-open-reader mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ count($courses) }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('student.unitregistration') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Academics</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-book-journal-whills mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ $mycourses }}--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" disabled=" " href=" {{ route('student.feesstatement') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Finance</div>
                        <div class="fs-2 fw-normal text-success">
                            <i class="fa fa-coins mt-2" style="font-size: 140% !important;"></i>
{{--                            {{ count($notification) }} --}}
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('student.examresults') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-warning">Examination</div>
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

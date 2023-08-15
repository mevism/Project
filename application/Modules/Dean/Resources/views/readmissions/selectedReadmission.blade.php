@extends('dean::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        VIEW READMISSION REQUEST
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Readmission</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Readmission
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center m-2">
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> STUDENT'S CURRENT STAGE</h6></legend>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Number </div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->StudentsReadmission->student_number }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Name</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->StudentsReadmission->surname.' '.$leave->StudentsReadmission->first_name.' '.$leave->StudentsReadmission->middle_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Class</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->current_class }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Course Admitted </div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->StudentsReadmission->EnrolledStudentCourse->course_name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Department Admitted</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->StudentsReadmission->EnrolledStudentCourse->getCourseDept->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Stage</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ 'Year'.' '.$leave->year_study.' Semester '.$leave->semester_study }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> DEFERMENT/ACADEMIC LEAVE DETAILS</h6></legend>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Leave Type</div>
                                    <div class="col-md-8 fs-sm">
                                        @if($leave->type == 1)
                                            ACADEMIC LEAVE
                                        @else
                                            DEFERMENT
                                        @endif

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Leave Dates</div>
                                    <div class="col-md-8 fs-sm">
                                       <b>From: </b> {{ $leave->from }} <br> <b>To:</b> {{ $leave->to }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Class (Placed)</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->readmission_class }}
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('dean.acceptReadmission', $leave->readmission_id) }}">
                                    @csrf
                                    <input type="hidden" name="class" value="{{ $leave->readimission_class }}">
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Stage</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->year_study.'.'.$leave->semester_study }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Readmission Period</div>
                                    <div class="col-md-8 fs-sm">
                                        <b>Academic Year : </b>{{ $leave->readmission_year }} <br><b>Academic Semester : </b>{{ $leave->readmission_semester }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Deferment Period</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ Carbon\Carbon::parse($leave->to)->diffInMonths(\Carbon\Carbon::parse($leave->from)) }} Months
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Reason(s)</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->reason }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        @if($leave->registrar_status <1)
                            @if($leave->dean_status < 1)
                                <button class="btn btn-outline-success col-md-2 m-2"> Accept Readmission </button>
                                <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Readmission</a>
                            @else
                                @if($leave->dean_status == 1)
                                    <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Readmission </a>
                                @else
                                    <button class="btn btn-outline-success col-md-2 m-2"> Accept Readmission </button>
                                @endif
                            @endif
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('dean.declineReadmission', $leave->readmission_id) }}">
                        @csrf
                        <div class="d-flex justify-content-center mb-4">
                            <div class="col-md-11">
                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                <input type="hidden" value="{{ $leave->id }}" name="transfer_id">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success col-md-5">Submit Remarks</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

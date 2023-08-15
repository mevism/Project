@extends('cod::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        VIEW REQUEST
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Course Transfers
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
                                        {{ $readmision->StudentsReadmission->student_number }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Name</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $readmision->StudentsReadmission->surname.' '.$readmision->StudentsReadmission->first_name.' '.$readmision->StudentsReadmission->middle_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Class</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $readmision->current_class }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Course Admitted</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $readmision->StudentsReadmission->EnrolledStudentCourse->course_name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Department Admitted</div>
                                    <div class="col-md-9 fs-sm">
                                        {{  $readmision->StudentsReadmission->EnrolledStudentCourse->getCourseDept->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Stage</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ 'Year'.' '.$readmision->year_study.' Semester '.$readmision->semester_study }}
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
                                        @if($readmision->type == 1)
                                            ACADEMIC LEAVE
                                        @else
                                            DEFERMENT
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Leave Dates</div>
                                    <div class="col-md-8 fs-sm">
                                        From: {{ $readmision->from }} - To: {{ $readmision->to }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Class (Requested)</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $readmision->defer_class }}
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('department.acceptReadmission', $readmision->readmission_id) }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4 fw-bold">New Class (Placed)</div>
                                        <div class="col-md-8 fs-sm">
                                            <select name="class" class="form-control col-md-8">
                                                <option class="text-center" disabled selected>-- select class --</option>
                                                @foreach($classes as $class)
                                                    @foreach($class as $classname => $class)
                                                        <option value="{{ $classname }}">{{ $classname }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="stage" value="{{ $readmision->year_study.".".$readmision->semester_study }}">
                                    </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Stage</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $readmision->stage }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Readmission Period</div>
                                    <div class="col-md-8 fs-sm">
                                        <b>Academic Year :</b> {{ $readmision->academic_year }} <br> <b>Semester</b> {{ $readmision->academic_semester }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Deferment Period</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ Carbon\Carbon::parse($readmision->to)->diffInMonths(\Carbon\Carbon::parse($readmision->from)) }} Months
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Reason(s)</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $readmision->reason }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        @if($readmision->dean_status < 1)
                            @if($readmision->cod_status == 0)
                                <button class="btn btn-outline-success col-md-2 m-2"> Accept Transfer </button>
                                <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                            @else
                                @if($readmision->cod_status == 1)
                                    <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer </a>
                                @else
                                    <button class="btn btn-outline-success col-md-2 m-2"> Accept Transfer </button>
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
                    <form method="POST" action="{{ route('department.declineReadmission', $readmision->readmission_id) }}">
                        @csrf
                        <div class="d-flex justify-content-center mb-4">
                            <div class="col-md-11">
                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                <input type="hidden" value="{{ $readmision->readmision_id }}" name="transfer_id">
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

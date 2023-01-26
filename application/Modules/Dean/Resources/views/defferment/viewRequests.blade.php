@extends('dean::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        VIEW REQUEST
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
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
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> STUDENT'S CURRENT STAGE</h6></legend>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Reg. Number </div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->studentLeave->reg_number }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Name</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->studentLeave->sname.' '.$leave->studentLeave->fname.' '.$leave->studentLeave->mname }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Class</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->studentLeave->courseStudent->class_code }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Course</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->studentLeave->courseStudent->studentCourse->course_name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Department</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $leave->studentLeave->courseStudent->studentCourse->getCourseDept->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Stage</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ 'Year'.' '.$current->year_study.' Semester'.$current->semester_study.' '.'('.$current->patternRoll->season.')' }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2">
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
                                       From: {{ $leave->from }} - To: {{ $leave->to }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Class</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->deferredClass->deferred_class }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Stage</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->deferredClass->stage }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Readmission Period</div>
                                    <div class="col-md-8 fs-sm">
                                        Academic Year {{ $leave->deferredClass->academic_year }} Semester {{ $leave->deferredClass->semester_study }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Deferment Period</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ Carbon\Carbon::parse($leave->to)->diffInMonths(\Carbon\Carbon::parse($leave->from)) }} Months
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Deferment Reason(s)</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $leave->reason }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        @if($leave->approveLeave->dean_status == null)
                            <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('dean.acceptLeaveRequest', ['id' => Crypt::encrypt($leave->id)]) }}"> Accept Transfer </a>
                            <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                        @else
                            @if($leave->approveLeave->dean_status == 1)
                                <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                            @else
                                <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('dean.acceptLeaveRequest', ['id' => Crypt::encrypt($leave->id)]) }}"> Accept Transfer </a>
                            @endif
                        @endif
                    </div>
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
                    <form method="POST" action="{{ route('dean.declineLeaveRequest', ['id' => Crypt::encrypt($leave->id)]) }}">
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

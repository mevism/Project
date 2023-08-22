@extends('cod::layouts.backend')
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
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> STUDENT'S CURRENT COURSE</h6></legend>
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">STUDENT NUMBER </div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->student_number }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">STUDENT NAME</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->surname.' '.$transfer->first_name.' '.$transfer->middle_name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">STUDENT DEPARTMENT</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->StudentsTransferCourse->StudentsCourse->getCourseDept->name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">COURSE ENROLLED</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->StudentsTransferCourse->StudentsCourse->course_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">CLASS ADMITTED</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->StudentsTransferCourse->current_class }}
                                    </div>
                                </div>
                                @if($transfer->level_id == 2)
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">ACADEMIC DOCUMENTS</div>
                                    <div class="col-md-7 fs-sm">
                                        <a class="btn btn-sm btn-outline-primary col-md-6" target="_blank" href="{{ route('department.viewUploadedDocument', $transfer->course_transfer_id) }}">View Document</a>
                                    </div>
                                </div>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> TRANSFER REQUEST DETAILS</h6></legend>
                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">DEPARTMENT TRANSFERRING TO</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->CourseTransferDept->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">COURSE TRANSFERRING TO</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->course_name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">CLASS TRANSFERRING TO</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">CLASS CUTOFF POINTS/GRADE</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ strtoupper($transfer->class_points) }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">STUDENT'S POINTS/GRADE</div>
                                    <div class="col-md-7 fs-sm">
                                        {{ strtoupper($transfer->student_points)  }}
                                    </div>
                                </div>

                                @if($transfer->level_id == 3)
                                    <div class="row mb-3">
                                        <div class="col-md-5 fs-sm fw-bold">RECOMMENDATIONS </div>
                                        <div class="col-md-7 fs-sm">
                                            @if($transfer->student_points >= $transfer->class_points)
                                                <span class="badge bg-success"> Meets minimum cluster points requirements </span>
                                            @else
                                                <span class="badge bg-danger"> Doesn't meet minimum cluster points requirements </span>

                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($transfer->level_id == 2)

                                <div class="row mb-3">
                                    <div class="col-md-5 fs-sm fw-bold">COURSE SUBJECT REQUIREMENT </div>
                                    <div class="col-md-7 fs-sm">
                                        {{ $transfer->TransferCourse->courseRequirements->subject1 }} <br>
                                        {{ $transfer->TransferCourse->courseRequirements->subject2 }} <br>
                                        {{ $transfer->TransferCourse->courseRequirements->subject3 }} <br>
                                        {{ $transfer->TransferCourse->courseRequirements->subject4 }}

                                    </div>

                                </div>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        @if($transfer->cod_status == null)
                            <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('department.acceptTransferRequest', $transfer->course_transfer_id) }}"> Accept Transfer </a>
                            <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                        @else
                            @if($transfer->cod_status == 1 && $transfer->dean_status == null)
                                <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                            @elseif($transfer->cod_status == 2 && $transfer->dean_status == null)
                                <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('department.acceptTransferRequest', $transfer->course_transfer_id) }}"> Accept Transfer </a>
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
                        <form method="POST" action="{{ route('department.declineTransferRequest', $transfer->course_transfer_id) }}">
                            @csrf
                            <div class="d-flex justify-content-center mb-4">
                            <div class="col-md-11">
                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                <input type="hidden" value="{{ $transfer->course_transfer_id}}" name="transfer_id">
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

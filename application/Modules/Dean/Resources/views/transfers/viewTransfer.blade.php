@extends('dean::layouts.backend')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0">
                    STUDENT TRANSFER REQUEST
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Department</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Transfer
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
                                    <div class="col-md-3 fw-bold">Reg. Number </div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $data->transferApproval->studentTransfer->reg_number }}
                                    </div>  
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Name</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $data->transferApproval->studentTransfer->sname.' '.$data->transferApproval->studentTransfer->fname.' '.$data->transferApproval->studentTransfer->mname }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Class</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $data->transferApproval->studentTransfer->courseStudent->class_code }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Course</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $data->transferApproval->studentTransfer->courseStudent->studentCourse->course_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Department</div>
                                    <div class="col-md-9 fs-sm">
                                        {{ $data->transferApproval->studentTransfer->courseStudent->studentCourse->getCourseDept->name }}
                                    </div>
                                </div>
                                @if($data->transferApproval->courseTransfer->level == 2)
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">KCSE Results</div>
                                    <div class="col-md-9 fs-sm">
                                        <a class="btn btn-sm btn-outline-primary col-md-6" target="_blank" href="{{ route('dean.viewUploadedDocument', ['id' => Crypt::encrypt($data->id)]) }}">View Document</a>
                                    </div>
                                </div>
                                @endif
                        </fieldset>
                    </div>
                    <div class="col-md-6 p-2">
                        <fieldset class="border p-2" style="height: 100% !important;">
                            <legend class="float-none w-auto"><h6 class="fw-bold text-center"> TRANSFER REQUEST DETAILS</h6></legend>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">New Department</div>
                                <div class="col-md-8 fs-sm">
                                    {{ $data->transferApproval->deptTransfer->name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">New Course</div>
                                <div class="col-md-8 fs-sm">
                                    {{ $data->transferApproval->courseTransfer->course_name }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">New Class</div>
                                <div class="col-md-8 fs-sm">
                                    {{ $data->id }}
                                    {{ $data->transferApproval->classTransfer->name }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Course Requirement</div>
                                <div class="col-md-8 fs-sm">
                                    {{ $data->transferApproval->class_points }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Student Points/Grade</div>
                                <div class="col-md-8 fs-sm">
                                    {{ $data->transferApproval->student_points}}
                                </div>
                            </div>

                            @if( $data->transferApproval->courseTransfer->level == 3)
                                    <div class="row mb-3">
                                        <div class="col-md-4 fw-bold">Recommendation</div>
                                        <div class="col-md-8 fs-sm">
                                            @if( $data->transferApproval->student_points >=  $data->class_points)
                                                <span class="badge bg-success"> Meets all minimum requirements </span>
                                            @else
                                                <span class="badge bg-danger"> Does not meet all minimum requirements </span>

                                            @endif
                                        </div>
                                    </div>
                            @endif

                            @if($data->transferApproval->courseTransfer->level == 2)

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Subject Requirements</div>
                                    <div class="col-md-8 fs-sm">
                                        {{ $data->transferApproval->courseTransfer->courseRequirements->subject1 }} <br>
                                        {{ $data->transferApproval->courseTransfer->courseRequirements->subject2 }} <br>
                                        {{ $data->transferApproval->courseTransfer->courseRequirements->subject3 }} <br>
                                        {{ $data->transferApproval->courseTransfer->courseRequirements->subject4 }}

                                    </div>
                                </div>
                            @endif

                        </fieldset>
                    </div>
                </div>

                <div class="d-flex justify-content-center m-2">
                    @if($data->dean_status == null)
                        <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('dean.acceptTransferRequest', [ 'id' => Crypt::encrypt($data->id)]) }}"> Accept Transfer </a>
                        <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                    @else
                        @if($data->dean_status  == 1)
                            <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Transfer</a>
                        @else
                            <a class="btn btn-outline-success col-md-2 m-2" href="{{ route('dean.acceptTransferRequest', [ 'id' => Crypt::encrypt($data->id)]) }}"> Accept Transfer </a>
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
                    <form method="POST" action="{{ route('dean.declineTransferRequest', [ 'id' => Crypt::encrypt($data->id)]) }}">
                        @csrf
                        <div class="d-flex justify-content-center mb-4">
                        <div class="col-md-11">
                            <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                            <input type="hidden" value="{{ $data->id }}" name="transfer_id">
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
@extends('cod::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Update Application Status
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Status
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <div class="row p-1">
                        <div class="col-md-4 fw-bolder text-start">Applicant Name </div>
                        <div class="col-md-8"> {{ $app->applicant->sname }} {{ $app->applicant->fname }} {{ $app->applicant->mname }}</div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Department</div>
                            <div class="col-md-8"> {{ $app->courses->department_id }} </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Course Name</div>
                            <div class="col-md-8"> {{ $app->courses->course_name }} </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Institution</div>
                            <div class="col-md-8"> {{ $school->institution }} </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">KCSE Grade</div>
                            <div class="col-md-8"> {{ $school->qualification }} </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Cluster Subjects</div>
                            <div class="col-md-8">
                               <p> ENGLISH {{ $app->subject_1 }}</p>
                                <p> MATHEMATICS {{ $app->subject_2 }}</p>
                                <p> BUSINESS {{ $app->subject_3 }}</p>
                                <p> HISTORY {{ $app->subject_4 }}</p>
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">COD Status</div>
                            <div class="col-md-8">
                                @if($app->cod_status === 0)
                                    <span class="badge bg-primary">Pending</span>
                                @elseif($app->cod_status === 1)
                                    <span class="badge bg-success">Approved by COD</span>
                                @elseif($app->cod_status === 2)
                                    <span class="badge bg-danger">Rejected by COD</span>
                                @else
                                    <span class="badge bg-info"> Awaiting COD review</span>
                                @endif
                            </div>
                        </div>
                        @if($app->dean_status === 3)
                            <div class="row p-1">
                                <div class="col-md-4 fw-bolder text-start">Dean Comments</div>
                                <div class="col-md-8"> {{ $app->dean_comments }} </div>
                            </div>
                        @endif
                        @if($app->registrar_status === 4)
                            <div class="row p-1">
                                <div class="col-md-4 fw-bolder text-start">Registrar Comments</div>
                                <div class="col-md-8"> {{ $app->registrar_comments }} </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 space-y-2">
                        <div class="d-flex justify-content-center">
                            <div class="card-img" style="margin: auto !important;">
                                <img style="margin: auto !important; max-height: 80vh !important; width: 100% !important;" src="{{ url('certs/', $school->certificate) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="d-flex justify-content-center py-1">
            @if($app->cod_status === 0)
            <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('cod.acceptApplication', $app->id) }}">Approve</a>
            <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Reject</a>
            <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('cod.applications') }}">Close</a>
                @elseif($app->dean_status === 3)
                <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('cod.acceptApplication', $app->id) }}">Approve</a>
                <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Reject</a>
                <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('cod.applications') }}">Close</a>
            @elseif($app->cod_status === 1)
                <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Reject</a>
                <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('cod.applications') }}">Close</a>
            @else
                <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('cod.acceptApplication', $app->id) }}">Approve</a>
                <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('cod.applications') }}">Close</a>
            @endif
        </div>
        </div>
    </div>

    <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Reason(s) </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <form action="{{ route('cod.rejectApplication', $app->id) }}" method="post">
                            @csrf
                            <div class="row col-md-12 mb-3">
                            <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required></textarea>
                            <input type="hidden" name="{{ $app->id }}">
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                            <button type="submit" class="btn btn-alt-danger btn-sm">Reject</button>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                        {{--                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Okay</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

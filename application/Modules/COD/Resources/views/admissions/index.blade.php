@extends('cod::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Admissions
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Admissions</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Approvals
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <table id="example" class="table table-responsive table-md table-striped table-bordered table-vcenter fs-sm">
                        @if(count($applicant)>0)
                            <thead>
                            <th>#</th>
                            <th>Applicant Name</th>
                            <th>Department</th>
                            <th>Course Name</th>
                            <th>Status</th>
                            <th style="white-space: nowrap !important;">Action</th>
                            </thead>

{{--                        @foreach($applicant as $app)--}}

{{--                            {{ $app->applicant }} <br>--}}
                            <tbody>
                            @foreach($applicant as $app)
                                <tr>
                                    <td scope="row"> {{ $loop->iteration }}</td>
                                    <td> {{ $app->applicant->sname }} {{ $app->applicant->fname }} {{ $app->applicant->mname }} </td>
                                    <td> {{ $app->courses->getCourseDept->name }}</td>
                                    <td> {{ $app->courses->course_name }}</td>
                                    <td>
{{--                                        {{ $app->admApproval }}--}}
                                        @if($app->admApproval === NULL)
                                            <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending</span>
                                        @elseif($app->admApproval->cod_status === 1)
                                            <span class="badge bg-success"> <i class="fa fa-check"></i> accepted</span>
                                        @else
                                            <span class="badge bg-danger"> <i class="fa fa-close"></i> rejected</span>
                                        @endif
                                    </td>
                                    <td nowrap="">

                                        @if($app->applicant->student_type === 2)
                                            @if($app->admApproval === NULL)
                                                <a class="btn btn-sm btn-alt-info" onclick="return confirm('Are you sure you want to approve?')" data-toggle="click-ripple" href="{{ route('cod.acceptAdmission', $app->id) }}">Accept</a>
                                                <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin-{{ $app->id }}"> Reject</a>

                                                <div class="modal fade" id="modal-block-popin-{{ $app->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-popin" role="document">
                                                        <div class="modal-content">
                                                            <div class="block block-rounded block-transparent mb-0">
                                                                <div class="block-header block-header-default">
                                                                    <h3 class="block-title">Reason(s) for rejecting {{ $app->applicant->sname }}'s admission</h3>
                                                                    <div class="block-options">
                                                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="fa fa-fw fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content fs-sm">
                                                                    <form action="{{ route('cod.rejectAdmission', $app->id) }}" method="post">
                                                                        @csrf
                                                                        <div class="row col-md-12 mb-3">
                                                                            <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required></textarea>
                                                                            <input type="hidden" name="id" value="{{ $app->id }}">
                                                                        </div>
                                                                        <div class="d-flex justify-content-center mb-2">
                                                                            <button type="submit" class="btn btn-alt-danger btn-sm">Reject</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div class="block-content block-content-full text-end bg-body">
                                                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @elseif($app->admApproval->cod_status === 1)
                                                <a class="btn btn-sm btn-alt-success" data-toogle="click-ripple" onclick="return confirm('Are you sure you want to submit this record?')" href="{{ route('cod.submitAdmission', $app->id) }}"> Submit </a>
                                                <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin-{{ $app->id }}"> Reject</a>
                                                <div class="modal fade" id="modal-block-popin-{{ $app->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-popin" role="document">
                                                        <div class="modal-content">
                                                            <div class="block block-rounded block-transparent mb-0">
                                                                <div class="block-header block-header-default">
                                                                    <h3 class="block-title"> Reason(s) for rejecting {{ $app->applicant->sname }}'s admission </h3>
                                                                    <div class="block-options">
                                                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="fa fa-fw fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content fs-sm">
                                                                    <form action="{{ route('cod.rejectAdmission', $app->id) }}" method="post">
                                                                        @csrf
                                                                        <div class="row col-md-12 mb-3">
                                                                            <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required></textarea>
                                                                            <input type="hidden" name="id" value="{{ $app->id }}">
                                                                        </div>
                                                                        <div class="d-flex justify-content-center mb-2">
                                                                            <button type="submit" class="btn btn-alt-danger btn-sm">Reject</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div class="block-content block-content-full text-end bg-body">
                                                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a class="btn btn-sm btn-alt-info" onclick="return confirm('Are you sure you want to approve?')" data-toggle="click-ripple" href="{{ route('cod.acceptAdmission', $app->id) }}">Accept</a>
                                            @endif

                                        @else
                                            @if($app->admApproval === NULL)
                                                    <a class="btn btn-sm btn-alt-info" href="{{ route('cod.reviewAdmission', $app->id) }}"> Verify </a>
                                            @elseif($app->admApproval->cod_status === 1)
                                                <a class="btn btn-sm btn-alt-info" href="{{ route('cod.reviewAdmission', $app->id) }}"> Edit </a>
                                                <a class="btn btn-sm btn-alt-success" data-toogle="click-ripple" onclick="return confirm('Are you sure you want to submit this record?')" href="{{ route('cod.submitAdmission', $app->id) }}"> Submit </a>
                                            @else
                                                    <a class="btn btn-sm btn-alt-info" href="{{ route('cod.reviewAdmission', $app->id) }}"> Edit </a>

                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no new applications submitted</span>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[5, 'asc']],
            rowGroup: {
                dataSrc: 2
            },

        } );
    } );
</script>

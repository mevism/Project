@extends('medical::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

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

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        Admissions
                    </h6>
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
                    <table id="example" class="table table-responsive table-striped table-sm table-bordered fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Gender</th>
                        <th>Disability</th>
                        <th>Status</th>
                        <th style="white-space: nowrap !important;">Action</th>
                        </thead>
                        <tbody>
                        @foreach($admission as $app)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td nowrap="">{{ $app->sname }} {{ $app->mname }} {{ $app->fname }}</td>
                                <td>{{ $app->gender }}</td>
                                <td>
                                    @if($app->disabled == 'NO')
                                        {{ $app->disabled }}
                                    @else
                                        {{ $app->disabled }}, {{ $app->disability }}
                                    @endif
                                </td>
                                <td>
                                    @if($app->medical_status == 0)
                                        <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending</span>
                                    @elseif($app->medical_status == 1)
                                        <span class="badge bg-success"> <i class="fa fa-check"></i> approved</span>
                                    @elseif($app->medical_status == 2)
                                        <span class="badge bg-danger"> <i class="fa fa-close"></i> rejected</span>
                                    @else
                                        <span class="badge bg-info"> <i class="fa fa-close"></i> Withheld</span>
                                    @endif
                                </td>
                                <td nowrap="">
                                    @if($app->medical_status == 0)
                                        <a class="btn btn-sm btn-alt-primary" href="{{ route('medical.reviewAdmission', $app->application_id) }}" data-toggle="click-ripple">Verify</a>
                                    @elseif($app->medical_status == 1)
                                        <a class="btn btn-sm btn-alt-success" data-toogle="click-ripple" onclick="return confirm('Are you sure you want to submit this record?')" href="{{ route('medical.submitAdmission', $app->application_id) }}"> submit</a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('medical.reviewAdmission', $app->application_id) }}" data-toggle="click-ripple"> Edit</a>
                                    @else
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('medical.reviewAdmission', $app->application_id) }}" data-toggle="click-ripple"> Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection



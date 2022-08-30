@extends('applications::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">--}}

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Application Approval
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
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
                    <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                        @if(count($apps)>0)
                            <thead>
                                <th></th>
                            <th>Applicant Name</th>
                            <th>Course Name</th>
                            <th>Transaction code</th>
                            <th>Status</th>
                            <th style="white-space: nowrap !important;">Action</th>
{{--                            <th style="display: none;"></th>--}}
                            </thead>
                            <tbody>
                            @foreach($apps as $app)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $app->applicant->sname }} {{ $app->applicant->fname }} {{ $app->applicant->mname }}</td>
                                <td> {{ $app->courses->course_name }}</td>
                                <td> {{ $app->receipt }}</td>
                                <td>
                                    @if($app->finance_status === 0)
                                        <span class="badge bg-primary">Awaiting</span>
                                    @elseif($app->finance_status === 1)
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif($app->finance_status === 2)
                                        <span class="badge bg-warning">Rejected</span>
                                    @else
                                        <span class="badge bg-primary">Awaiting</span>
                                    @endif
                                </td>
                                <td>
                                @if($app->finance_status == null)
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('finance.viewApplication', $app->id) }}"> View </a>
                                        @else
                                    <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('finance.previewApplication', $app->id) }}"> View </a>
                                <a class="btn btn-sm btn-alt-info" href="{{ route('finance.viewApplication', $app->id) }}"> Edit </a>
                                    </div>
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
            order: [[2, 'desc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>

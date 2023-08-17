@extends('cod::layouts.backend')
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
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        VIEW {{ $year }} SEMESTER WORKLOADS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Workload</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Workload
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
                    <table id="example" class="table table-borderless table-sm table-striped fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Academic Semester </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($workloads as $semester => $workload)
                            <tr>
                                <td> {{ $loop->iteration}} </td>
                                <td>
                                    {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $semester)->first()->intake_month }}
                                </td>
                                <td nowrap="">
                                    @if ($workload->first()->workload_approval_id == null)
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.viewSemesterWorkload', $semester) }}"> <i class="fa fa-eye"></i> View </a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-download"></i> Download </a>
                                        <a class="btn btn-sm btn-alt-success" href="{{ route('department.submitWorkload', $semester) }}"><i class="fa fa-save"></i> Submit </a>
                                    @elseif($workload->first()->workload_approval_id != null && $workload->first()->status === 0)
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.viewSemesterWorkload', $semester) }}"> <i class="fa fa-eye"></i> View </a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-download"></i> Download </a>
                                    @elseif($workload->first()->workload_approval_id != null &&  $workload->first()->status == 2)
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.viewSemesterWorkload', $semester) }}"> <i class="fa fa-eye"></i> Review </a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-download"></i> Download </a>
                                        <a class="btn btn-sm btn-alt-success" href="{{ route('department.submitWorkload', $semester) }}"><i class="fa fa-save"></i> Resubmit </a>
                                        <a class="btn-link link-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $workload->first()->workload_approval_id }}"> Why Rejected? </a>
                                        <div class="modal fade" id="staticBackdrop-{{ $workload->first()->workload_approval_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">DEAN'S REMARKS</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            @if($workload->first()->workloadApproval != null)
                                                                <p>
                                                                    Dean's Remarks: {{ $workload->first()->workloadApproval->dean_remarks }}
                                                                </p>
                                                                <p>
                                                                    Registrar's Remarks: {{ $workload->first()->workloadApproval->registrar_remarks }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($workload->first()->status == 1 && $workload->first()->workloadApproval->status == 1)
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.viewSemesterWorkload', $semester) }}"> <i class="fa fa-eye"></i> View </a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-download"></i> Download </a>
                                        <a class="btn btn-sm btn-alt-success disabled" href="{{ route('department.submitWorkload', $semester) }}"><i class="fa fa-check-circle"></i> Published </a>
                                    @elseif($workload->first()->workload_approval_id !== null &&  $workload->first()->status == 0)
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.viewSemesterWorkload', $semester) }}"> <i class="fa fa-eye"></i> View </a>
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-download"></i> Download </a>
                                        <a class="btn btn-sm btn-alt-primary disabled" href="{{ route('department.printWorkload', $semester) }}"><i class="fa fa-spinner"></i> Under Review </a>
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

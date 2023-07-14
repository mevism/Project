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
                    <h6 class="h6 fw-bold mb-0">
                        VIEW {{ $year }} SEMESTER WORKLOADS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
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
                                    {{ $semester }}
                                </td>
                                <td nowrap="">
                                    @if ($workload->first()->workload_approval_id == null)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group">
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.viewSemesterWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-info"> View </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.printWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.submitWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" onclick="return confirm('Are sure you want to submit this workload?')" class="btn btn-sm btn-outline-success"> Submit </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($workload->first()->workload_approval_id != null && $workload->first()->status === 0)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group">
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.viewSemesterWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-info"> View </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.printWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($workload->first()->workload_approval_id != null &&  $workload->first()->status == 2)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group">
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.viewSemesterWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-info"> Review </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.submitWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" onclick="return confirm('Are sure you want to resubmit this workload?')" class="btn btn-sm btn-outline-success"> Resubmit </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.printWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>
                                                    </form>
                                                </div>
                                                <span>&nbsp;</span>
                                                <a class="btn-link link-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $workload->first()->workload_approval_id }}"> Why Rejected? </a>
                                            </div>
                                        </div>

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
                                    @elseif($workload->first()->workload_approval_id != null &&  $workload->first()->status === 1)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group">
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.viewSemesterWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-info"> View </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0" method="post" action="{{ route('department.printWorkload') }}">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <input type="hidden" name="semester" value="{{ $semester }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>
                                                    </form>
                                                    <span>&nbsp;</span>
                                                    <form class="m-0 p-0">
                                                        <a class="btn btn-outline-success btn-sm disabled" disabled> Published </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

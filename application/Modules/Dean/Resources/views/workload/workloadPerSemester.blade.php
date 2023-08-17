@extends('dean::layouts.backend')
<script src="https://code.jquery.com/jquery-3.7.0.slim.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

{{--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}
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
                    <h5 class="h6 fw-bold mb-0 text-uppercase">
                       {{ base64_decode($year) }}  WORKLOAD
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">SCHOOL</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            DEPARTMENTAL WORKLOAD
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
                    <table id="example" class="table table-bordered table-sm table-striped fs-sm">

                        <thead>
                        <th>#</th>
                        <th>Academic Year </th>
                        <th>Academic semester</th>
                        <th>department </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($workloads as $department  => $workload)
                            @foreach($workload as $semester => $load)
                                <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ base64_decode($year) }} </td>
                                <td> {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $semester)->first()->intake_month }} </td>
                                <td>{{ \Modules\Registrar\Entities\Department::where('department_id', $department)->first()->name }}</td>
                                <td nowrap="">
                                    <a class="btn btn-sm btn-outline-info" href="{{ route('dean.viewWorkload', base64_encode($department. ':' .$semester)) }}">View </a>
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('dean.printWorkload', base64_encode($department.':'.$semester)) }}">Download </a>
                                    @if($load->first()->dean_status == 0)
                                        <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to approve this workload?')" href="{{ route('dean.approveWorkload', base64_encode($department.':'.$semester)) }}">Approve </a>
                                        <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $department.$semester }}"> Decline </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == null)
                                        <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $department.$semester }}"> Decline </a>
                                        <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to submit this workload?')" href="{{ route('dean.submitWorkload', base64_encode($department.':'.$semester)) }}"> Submit </a>
                                    @elseif($load->first()->dean_status == 2 && $load->first()->registrar_status == null && $load->first()->status == 0 &&  $load->first()->WorkloadApprovalView->status == 0)
                                        <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to approve this workload?')" href="{{ route('dean.approveWorkload', base64_encode($department.':'.$semester)) }}">Approve </a>
                                        <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to revert this workload?')" href="{{ route('dean.revertWorkload', base64_encode($department.':'.$semester)) }}"> Revert </a>
                                    @elseif($load->first()->dean_status == 2 && $load->first()->WorkloadApprovalView->status == 2 || $load->first()->dean_status == 1 && $load->first()->WorkloadApprovalView->status == 2 )
                                        <a class="btn btn-sm btn-outline-danger disabled" href="{{ route('dean.printWorkload', base64_encode($department.':'.$semester)) }}">Under COD Review </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == 0)
                                        <a class="btn btn-sm btn-outline-success disabled" href="{{ route('dean.printWorkload', base64_encode($department.':'.$semester)) }}">Under Senate Review </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == 2 && $load->first()->status == 2)
                                        <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to approve this workload?')" href="{{ route('dean.approveWorkload', base64_encode($department.':'.$semester)) }}">Approve </a>
                                        <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to revert this workload?')" href="{{ route('dean.revertWorkload', base64_encode($department.':'.$semester)) }}"> Revert </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == 2 && $load->first()->status == 2)
                                        <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to revert this workload?')" href="{{ route('dean.revertWorkload', base64_encode($department.':'.$semester)) }}"> Revert </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == 1 && $load->first()->status == 1 && $load->first()->WorkloadApprovalView->status == 0)
                                        <a class="btn btn-sm btn-outline-success" href="{{ route('dean.workloadPublished', base64_encode($department.':'.$semester)) }}">Publish </a>
                                    @elseif($load->first()->dean_status == 1 && $load->first()->registrar_status == 1 && $load->first()->status == 1 && $load->first()->WorkloadApprovalView->status == 1)
                                        <a class="btn btn-sm btn-outline-success disabled" href="{{ route('dean.printWorkload', base64_encode($department.':'.$semester)) }}">Workload Published </a>
                                    @endif
                                    <div class="modal fade" id="staticBackdrop{{ $department.$semester }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="staticBackdropLabel">YOUR REMARKS ON {{ \Modules\Registrar\Entities\Department::where('department_id', $department)->first()->name }} {{\Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $semester)->first()->intake_month }} {{ base64_decode($year) }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('dean.declineWorkload', base64_encode($department.':'.$semester)) }}">
                                                        @csrf
                                                        <div class="d-flex justify-content-center mb-4">
                                                            <div class="col-md-11">
                                                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                                                 <input type="hidden" value="{{base64_encode($department.':'.$semester) }}" name="transfer_id">
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
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

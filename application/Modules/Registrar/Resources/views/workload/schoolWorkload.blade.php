@extends('registrar::layouts.backend')
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
                      SCHOOL WORKLOADS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Schools</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            workloads
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
                                <th>School</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                               @foreach($workloads as $school => $schoolWorkloads)
                                    @foreach($schoolWorkloads as $semester => $workload)
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td> {{ \Modules\Registrar\Entities\School::where('school_id', $school)->first()->name }} </td>
                                            <td> {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $semester)->first()->intake_month }} </td>
                                            <td>
                                                @if($workload->first()->WorkApprovalView->registrar_status == 0 && $workload->first()->WorkApprovalView->status == 0 || $workload->first()->WorkApprovalView->registrar_status == 1 && $workload->first()->WorkApprovalView->status == 0 || $workload->first()->WorkApprovalView->registrar_status == 2 && $workload->first()->WorkApprovalView->status == 0)
                                                    <span class="text-info">Pending</span>
                                                @elseif($workload->first()->WorkApprovalView->registrar_status == 2 && $workload->first()->WorkApprovalView->status == 2)
                                                    <span class="text-warning">Reverted for corrections</span>
                                                @elseif($workload->first()->WorkApprovalView->registrar_status == 1 && $workload->first()->WorkApprovalView->status == 1 && $workload->first()->WorkloadApprovalView->status == 0)
                                                    <span class="text-primary">Workload Approved </span>
                                                @elseif($workload->first()->WorkApprovalView->registrar_status == 1 && $workload->first()->WorkApprovalView->status == 1 && $workload->first()->WorkloadApprovalView->status == 1)
                                                    <span class="text-success">Workload Approved and Published </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.departmentalWorkload', base64_encode($school.':'.$semester)) }}">View</a>
                                                <a class="btn btn-sm btn-alt-info" href="{{ route('courses.printWorkload', base64_encode($school.':'.$semester)) }}">Download</a>
                                                @if($workload->first()->registrar_status == 0)
                                                    <a class="btn btn-sm btn-alt-success" onclick="return confirm('Are you sure you want to approve this workload?')" href="{{ route('courses.approveWorkload', base64_encode($school.':'.$semester)) }}">Approve</a>
                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $school.$semester }}"> Decline </a>
                                                @elseif($workload->first()->registrar_status == 1 && $workload->first()->status == 0)
                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $school.$semester }}"> Decline </a>
                                                    <a class="btn btn-sm btn-alt-success" onclick="return confirm('Are you sure you want to submit this workload? Once submitted cannot be reversed')" href="{{ route('courses.submitWorkload', base64_encode($school.':'.$semester)) }}">Submit</a>
                                                @elseif($workload->first()->registrar_status == 2 && $workload->first()->status == 0)
                                                    <a class="btn btn-sm btn-alt-success" onclick="return confirm('Are you sure you want to approve this workload?')" href="{{ route('courses.approveWorkload', base64_encode($school.':'.$semester)) }}">Approve</a>
                                                    <a class="btn btn-sm btn-alt-warning" onclick="return confirm('Are you sure you want to revert this workload?')" href="{{ route('courses.revertWorkload', base64_encode($school.':'.$semester)) }}">Revert </a>
                                                @elseif($workload->first()->dean_status == 1 && $workload->first()->registrar_status == 2 && $workload->first()->status == 2)
                                                    <a class="btn btn-sm btn-outline-info disabled">Under Dean's Review</a>
                                                @elseif($workload->first()->dean_status == 1 && $workload->first()->registrar_status == 1 && $workload->first()->status == 1)
                                                    <a class="btn btn-sm btn-outline-success disabled">Waiting Dean to Publish</a>
                                                @endif
{{--                                                @php--}}
{{--                                                    $academicYear = \Carbon\Carbon::parse($year->year_start)->format('Y').'/'.\Carbon\Carbon::parse($year->year_end)->format('Y');--}}
{{--                                                @endphp--}}
{{--                                                @if($workload->first()->registrar_status == 0 )--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="btn-group">--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.departmentalWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-info"> View </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.submitWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" onclick="return confirm('Are you sure you want to approve this workload?')" class="btn btn-sm btn-outline-success"> Approve </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $workload->first()->workload_approval_id }}"> Decline </a>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @elseif($workload->first()->registrar_status == 1 && $workload->first()->status == 0)--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="btn-group">--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.departmentalWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-info"> View </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}

{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.submitWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-success"> Submit </button>--}}
{{--                                                                </form>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @elseif($workload->first()->registrar_status == 2 && $workload->first()->status == 0)--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="btn-group">--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.departmentalWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-info"> View </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" onclick="return confirm('Are you sure you want to approve this workload?')" class="btn btn-sm btn-outline-success"> Approve </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.revertWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" onclick="return confirm('Are you sure you want to revert this workload?')" class="btn btn-sm btn-outline-warning"> Revert </button>--}}
{{--                                                                </form>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @elseif($workload->first()->WorkApprovalView->registrar_status == 2 && $workload->first()->WorkApprovalView->status == 2)--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="btn-group">--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.departmentalWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-info"> View </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @elseif($workload->first()->WorkApprovalView->registrar_status == 1 && $workload->first()->WorkApprovalView->status == 1)--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="btn-group">--}}
{{--                                                                <form class="m-0 p-0" method="post" action="{{ route('courses.departmentalWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-info"> View </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                                <form class="m-0 p-0" method="POST" action="{{ route('courses.approveWorkload') }}">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <input type="hidden" name="year" value="{{ $academicYear }}">--}}
{{--                                                                    <input type="hidden" name="semester" value="{{ $semester }}">--}}
{{--                                                                    <input type="hidden" name="school" value="{{ $school }}">--}}
{{--                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"> Download </button>--}}
{{--                                                                </form>--}}
{{--                                                                <span>&nbsp;</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}

                                            </td>
                                            <div class="modal fade" id="staticBackdrop{{ $school.$semester }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('courses.declineWorkload', base64_encode($school.':'.$semester)) }}">
                                                                @csrf
                                                                <div class="d-flex justify-content-center mb-4">
                                                                    <div class="col-md-11">
                                                                        <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
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

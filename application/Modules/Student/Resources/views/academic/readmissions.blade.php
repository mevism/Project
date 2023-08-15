@extends('student::layouts.backend')

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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0">
                        READMISSION
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ALL READMISSION REQUESTS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-0 mt-0">
                    <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('student.readmisionrequest') }}">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-borderless fs-sm">
                    <thead>
                    <th>#</th>
                    <th nowrap=""> Leave Type </th>
                    <th>REQUEST TO JOIN</th>
                    <th>JOIN AT STAGE</th>
                    <th>JOIN ON </th>
                    <th nowrap="">REQUESTED ON</th>
                    <th nowrap=""> Status</th>
                    <th nowrap=""> Action</th>
                    </thead>
                    <tbody>
                    @foreach($readmits as $key => $readmit)
                        <tr>
                            <td>{{ ++$key }} </td>
                            <td>
                                @if($readmit->type == 1)
                                    ACADEMIC LEAVE
                                @elseif($readmit->type == 2)
                                    DEFERMENT
                                @elseif($readmit->type == 3)
                                    SUSPENSION
                                @else
                                    DISCONTINUATION
                                @endif
                            </td>
                            <td>{{ $readmit->defer_class }}</td>
                            <td>{{ $readmit->year_study.'.'.$readmit->semester_study }}</td>
                            <td>
                                <span class="fw-semibold"> Academic Year : </span> {{ $readmit->academic_year }} <br>
                                <span class="fw-semibold"> Academic Sem. : </span> {{ $readmit->academic_semester }}
                            </td>
                            <td>
                                <span class="fw-semibold"> Academic Year : </span> {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $readmit->intake_id)->first()->academic_year }} <br>
                                <span class="fw-semibold"> Academic Sem. : </span> {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $readmit->intake_id)->first()->intake_month }}
                            </td>
                            <td nowrap="">
                                @if($readmit->cod_status == null)
                                        <span class="text-info">Pending</span>
                                @elseif($readmit->cod_status > 0 && $readmit->status == null )
                                        <span class="text-primary">Processing</span>
                                @elseif($readmit->status == 1 && $readmit->cod_status == 1)
                                    <span class="text-success"> Successful</span>
                                @elseif($readmit->status == 2)
                                    <span class="text-danger"> Unsuccessful</span>
                                @endif
                            </td>
                            <td nowrap="">
                               @if($readmit->cod_status > 0 && $readmit->status == null )
                                   <a class="btn btn-sm btn-outline-secondary" disabled=""> Processing </a>
                               @elseif($readmit->status == 1 && $readmit->cod_status == 1)
                                        <a class="btn btn-sm btn-outline-success" disabled=""> Processed </a>
                                @elseif($readmit->cod_status == null)
                                    <a class="btn btn-sm btn-alt-danger" href="#">Withdraw</a>
                               @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

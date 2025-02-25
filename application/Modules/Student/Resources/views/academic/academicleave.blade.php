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
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        ACADEMIC LEAVE
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Student Progress</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ALL ACADEMIC LEAVES
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
                    <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('student.academicleaverequest') }}">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-borderless fs-sm">
                    <thead>
                        <th>#</th>
                        <th nowrap=""> CURRENT CLASS </th>
                        <th>Stage</th>
                        <th nowrap="">Academic Year</th>
                        <th nowrap="">Leave Type</th>
                        <th nowrap="">From - To</th>
                        <th nowrap="">Reason(s)</th>
                        <th nowrap=""> Status</th>
                    </thead>
                    <tbody>
                    @foreach($leaves as $key => $leave)
                        <tr>
                            <td>{{ ++$key }} </td>
                            <td> {{ $leave->current_class }} </td>
                            <td> Y{{ $leave->year_study }} S{{ $leave->semester_study}} </td>
                            <td> {{ $leave->academic_year }} </td>
                            <td nowrap="">
                                @if($leave->type == 1)
                                    ACADEMIC LEAVE
                                @else
                                    DEFERMENT
                                @endif
                            </td>
                            <td nowrap=""> From : {{ $leave->from }} <br> To : {{ $leave->to }}</td>
                            <td> {{ $leave->reason }} </td>
                            <td nowrap="">
                                @if($leave->cod_status < 1)
                                    <a class="btn btn-sm btn-alt-danger" href="{{ route('student.deleteleaverequest', $leave->leave_id) }}"> Withdraw </a>
                                @else
                                    @if($leave->status == 1)
                                        <span class="text-success fw-bold"> Successful </span>
                                    @elseif($leave->status == 2)
                                        <span class="text-danger fw-bold"> Unsuccessful</span>
                                    @else
                                        <span class="text-info fw-bold"> Processing</span>
                                    @endif
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

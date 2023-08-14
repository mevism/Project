@extends('dean::layouts.backend')

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
                       {{ strtoupper(\Carbon\Carbon::parse(\Modules\Registrar\Entities\Intake::where('intake_id', $intake)->first()->intake_from)->format('MY')) }} ACADEMIC/DEFERMENT LEAVE REQUESTS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="#">Leaves</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Annual deferment/academic leaves
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table id="example"  class="table table-sm table-striped table-borderless fs-sm">
                    <thead>
                    <th>#</th>
                    <th> Student Number </th>
                    <th> Student Name </th>
                    <th> Current Class </th>
                    <th> Period </th>
                    <th> New Class </th>
                    <th> Stage </th>
                    <th> Academic Year </th>
                    <th> Semester </th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($leaves as $key => $leave)
                            <tr>
                                <td> {{ ++$key}} </td>
                                <td> {{ $leave->StudentsLeave->student_number }} </td>
                                <td> {{ $leave->StudentsLeave->surname.' '.$leave->StudentsLeave->first_name.' '.$leave->StudentsLeave->middle_name }} </td>
                                <td> {{ $leave->current_class }} </td>
                                <td> {{ Carbon\Carbon::parse($leave->to)->diffInMonths(Carbon\Carbon::parse($leave->from)) }} Months</td>
                                <td> {{ $leave->defer_class }} </td>
                                <td> {{ $leave->year_study.'.'.$leave->semester_study }} </td>
                                <td> {{ $leave->academic_year }} </td>
                                <td> {{ $leave->academic_semester }} </td>
                                <td>
                                    <a class="btn btn-sm btn-outline-dark" href="{{ route('dean.viewLeaveRequest', $leave->leave_id) }}"> View </a>
                                    @if($leave->dean_status == 1)
                                        <span class="m-2 text-success">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    @elseif($leave->dean_status == 2)
                                        <span class="m-2 text-danger">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    @else
                                        <span class="m-2 text-info">
                                        <i class="fa fa-spinner"></i>
                                    </span>
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

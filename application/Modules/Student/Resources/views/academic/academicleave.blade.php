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
            order: [[2, 'asc']],
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
                    <h5 class="h5 fw-bold mb-0">
                        COURSE TRANSFERS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ALL TRANSFER REQUESTS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-sm btn-alt-primary" href="{{ route('student.academicleaverequest') }}">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    {{--                    <th> Department </th>--}}
                    <th nowrap=""> Course Name </th>
                    <th>Year of Study</th>
                    <th>Academic Year</th>
                    <th>Leave Type</th>
                    <th nowrap="">From - To</th>
                    <th nowrap="">Reason(s)</th>
                    <th nowrap=""> Status</th>
                    <th nowrap=""> Action</th>
                    {{--                    <th> Status </th>--}}
                    </thead>
                    <tbody>
                    @foreach($leaves as $key => $leave)
                        <tr>
                            <td>{{ ++$key }} </td>
                            <td> {{ $leave->studentLeave->courseStudent->studentCourse->course_name }} </td>
                            <td> Y{{ $leave->studentLeave->nominalRoll->year_study }} S{{ $leave->studentLeave->nominalRoll->semester_study}} </td>
                            <td> {{ $leave->academic_year }} </td>
                            <td nowrap="">
                                @if($leave->type == 1)
                                    ACADEMIC LEAVE
                                @else
                                    DEFERMENT
                                @endif
                            </td>
                            <td> {{ $leave->from }} - {{ $leave->to }}</td>
                            <td> {{ $leave->reason }} </td>
                            <td nowrap="">
                                @if($leave->status === NULL)
                                    <span class="text-primary fw-bold">Not Submitted</span>
                                @elseif($leave->status === 0)
                                    <span class="text-info fw-bold"> Submitted</span>
                                @elseif($leave->status === 1)
                                    <span class="text-success fw-bold"> Successful</span>
                                @else
                                    <span class="text-danger fw-bold"> Unsuccessful</span>
                                @endif
                            </td>
                            <td nowrap="">
                            @if($leave->status === NULL)
                                    <a class="btn btn-sm btn-alt-success" href="{{ route('student.submitsleaverequest', ['id' => Crypt::encrypt($leave->id)]) }}">Submit</a> |
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('student.editleaverequest', ['id' => Crypt::encrypt($leave->id)]) }}">Edit</a> |
                                    <a class="btn btn-sm btn-alt-danger" href="{{ route('student.deleteleaverequest', ['id' => Crypt::encrypt($leave->id)]) }}">Delete</a>
                            @else
                                    @if($leave->status === 0)
                                        <a class="btn btn-sm btn-outline-secondary" disabled=""> Processing </a>
                                    @else
                                        <a class="btn btn-sm btn-outline-success" disabled=""> Processed </a>
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

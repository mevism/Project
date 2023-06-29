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
                <div class="d-flex justify-content-end mb-0">
                    <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('student.requesttransfer') }}">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th> Course Department </th>
                    <th nowrap=""> Course Name </th>
                    <th nowrap=""> Class Code </th>
                    <th nowrap="">Class Cut-Off </th>
                    <th nowrap=""> Student Points</th>
                    <th nowrap=""> Status </th>
                    </thead>
                    <tbody>
                    @foreach($transfers as $key => $transfer)
                        <tr>
                            <td>{{ ++$key }} </td>
                            <td> {{ $transfer->deptTransfer->name }}</td>
                            <td> {{ $transfer->courseTransfer->course_name }}</td>
                            <td nowrap=""> {{ $transfer->classTransfer->name }}</td>
                            <td> {{ $transfer->class_points }} </td>
                            <td> {{ $transfer->student_points }} </td>
                            <td nowrap="">
                                @if($transfer->status == 0)
                                    <span class="text-info"> Pending </span>
                                @elseif($transfer->status == 1)
                                    <span class="text-primary">Processing </span>
                                @elseif($transfer->status == 2)
                                    <span class="text-success">Accepted </span>
                                @else
                                    <span class="text-danger">Declined </span>
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


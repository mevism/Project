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
                    <a class="btn btn-sm btn-alt-primary" href="{{ route('student.readmisionrequest') }}">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th nowrap=""> Course Name </th>
                    <th>Year of Study</th>
                    <th>Academic Year</th>
                    <th nowrap="">Reason(s)</th>
                    <th nowrap=""> Status</th>
                    <th nowrap=""> Action</th>
                    </thead>
                    <tbody>
                    @foreach($readmits as $key => $readmit)
                        <tr>
                            <td>{{ ++$key }} </td>
                            <td>{{ $readmit }}</td>
                            <td>{{ $readmit }}</td>
                            <td>{{ $readmit }}</td>
                            <td>{{ $readmit }}</td>
                            <td nowrap="">
                                @if($readmit->status == NULL)
                                    <span class="text-primary fw-bold">Not Submitted</span>
                                @elseif($readmit->status == 0)
                                    <span class="text-info fw-bold"> Submitted</span>
                                @elseif($readmit->status == 1)
                                    <span class="text-success fw-bold"> Successful</span>
                                @else
                                    <span class="text-danger fw-bold"> Unsuccessful</span>
                                @endif
                            </td>
                            <td nowrap="">
                                @if($readmit->status != NULL)
                                    @if($readmit->status == 0)
                                        <a class="btn btn-sm btn-outline-secondary" disabled=""> Processing </a>
                                    @else
                                        <a class="btn btn-sm btn-outline-success" disabled=""> Processed </a>
                                    @endif
                                @else
                                    <a class="btn btn-sm btn-alt-success" href="#">Submit</a> |
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('student.editleaverequest', ['id' => Crypt::encrypt($readmit->id)]) }}">Edit</a> |
                                    <a class="btn btn-sm btn-alt-danger" href="#">Delete</a>
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

@extends('dean::layouts.backend')
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
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0" >
                   COURSE TRANSFER
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Transfer</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Transfer
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="row">
            <div class="col-lg-12">
                <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                    @if(count($transfer)>0)
                        <thead>
                            <th>#</th>
                            <th>Reg. Number</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>COD Remarks</th>
                            <th>DEAN Remarks</th>
                            <th nowrap="">Action</th>
                        </thead>
                        <tbody>
                        @foreach($transfer as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->transferApproval->studentTransfer->reg_number }} </td>
                            <td>
                                {{ $item->transferApproval->studentTransfer->sname.' '.$item->transferApproval->studentTransfer->fname.' '.$item->transferApproval->studentTransfer->mname }}
                            </td>
                            <td> {{ $item->transferApproval->courseTransfer->course_code }}</td>
                            <td> {{ $item->transferApproval->deptTransfer->dept_code }}</td>
                             <td> {{ $item->cod_remarks }}</td>
                            <td>
                                @if($item->dean_remarks == null)
                                    <span class="badge bg-primary">Waiting approval</span>
                                @else
                                    <p class="text-success">{{ $item->dean_remarks }}</p>
                                @endif
                            </td>
                            <td nowrap="">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('dean.viewTransfer', $item->id) }}"> View </a>
                                @if($item->dean_status != null)
                                <i class="fa fa-check text-primary"></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    @else
                        <tr>
                            <span class="text-muted text-center fs-sm">There are no new transfers submitted</span>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

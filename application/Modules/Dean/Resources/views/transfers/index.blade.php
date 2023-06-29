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
                <h6 class="h6 fw-bold mb-0" >
                    {{ strtoupper(\Carbon\Carbon::parse(\Modules\Registrar\Entities\Intake::where('intake_id', $intake)->first()->intake_from)->format('MY')) }} COURSE TRANSFER
                </h6>
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
            <div class="col-12">
                <div class="d-flex justify-content-end m-2">
                    <a class="btn  btn-alt-primary btn-sm" href="{{ route('dean.requestedTransfers', $intake) }}">Generate report</a>
                </div>
                <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <thead>
                            <th>#</th>
                            <th>Student Number</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>COD Remarks</th>
                            <th>DEAN Remarks</th>
                            <th nowrap="">Action</th>
                        </thead>
                        <tbody>
                        @foreach($transfer as $key => $items)
                            @foreach($items as $item )
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td> {{ $item->student_number }} </td>
                            <td>
                                {{ $item->sname.' '.$item->fname.' '.$item->mname }}
                            </td>
                            <td> {{ $item->course_code }} </td>
                            <td> {{ $item->dept_code }} </td>
                             <td> {{ $item->cod_remarks }}</td>
                            <td>
                                @if($item->dean_remarks == null)
                                    <span class="badge bg-primary">Waiting approval</span>
                                    {{ $item->dean_remarks }}
                                @else
                                    @if($item->dean_status == 1)
                                        <p class="text-success">{{ $item->dean_remarks }}</p>
                                    @else
                                        <p class="text-danger">{{ $item->dean_remarks }}</p>
                                    @endif
                                @endif
                            </td>

                            <td nowrap="">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('dean.viewTransfer', $item->course_transfer_id) }}"> View </a>
                                @if($item->dean_status != null)
                                    @if($item->dean_status == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                @endif
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

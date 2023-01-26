@extends('registrar::layouts.backend')
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
            order: [[1, 'asc']],
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
                    {{$year}} COURSE TRANSFER REQUESTS
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
                <div class="col-12">
                    <div class="d-flex justify-content-end m-2">
                        <a class="btn  btn-alt-primary btn-sm" href="{{ route('courses.requestedTransfers', ['year' => Crypt::encrypt($year)]) }}">Generate report</a>
                    </div>
                    <form action="{{ route('courses.acceptedTransfers') }}" method="post">
                        @csrf
                        <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                            @if(count($transfer)>0)
                                <thead>
                                    <th>✔</th>
                                    <th>#</th>
                                    <th nowrap="">Old Stud. Number</th>
                                    <th nowrap="">Student name</th>
                                    <th nowrap="">New  Dept.</th>
                                    <th nowrap="">New Course</th>
                                    <th>COD Remarks</th>
                                    <th>DEAN STATUS</th>
                                </thead>
                                <tbody>
                                @foreach($transfer as $key => $items)
                                    @foreach($items as $item)
                                            <tr>
                                                <td>
                                                    @if($item->registrar_status == NULL )
                                                    <input class="transfer" type="checkbox" name="submit[]" value="{{ $item->id }}">
                                                        @else
                                                        ✔
                                                    @endif 
                                                </td>
                                                <td> {{ ++$key }} </td>
                                                <td> {{  $item->transferApproval->studentTransfer->reg_number }} </td>
                                                <td> {{  $item->transferApproval->studentTransfer->sname.' '.$item->transferApproval->studentTransfer->fname.' '.$item->transferApproval->studentTransfer->mname }} </td>
                                                <td> {{  $item->transferApproval->deptTransfer->dept_code }} </td>
                                                <td> {{  $item->transferApproval->courseTransfer->course_name }} </td>
                                                <td> {{  $item->cod_remarks }} </td>
                                                <td> 
                                                    @if($item->dean_status == 1)
                                                        <span class="badge bg-success">Accepted</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif 
                                                </td>
                                            </tr>
                                    @endforeach
                           
                                @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <span class="text-muted text-center fs-sm">There are no new transfers submitted</span>
                                </tr>
                            @endif
                        </table>
                        @if(count($transfer) > 0)
                        <div>
                            <input type="checkbox" onclick="for(c in document.getElementsByClassName('transfer')) document.getElementsByClassName('transfer').item(c).checked = this.checked"> Select all
                        </div>
                       
                        @endif
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success col-md-3 m-2" data-toggle="click-ripple">Generate letters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
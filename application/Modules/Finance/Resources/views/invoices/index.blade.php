@extends('applications::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">--}}

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        STUDENT FINANCE
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">STUDENT FINANCE</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            STUDENT INVOICES
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
                    <div class="d-flex justify-content-end m-2">
                        <a class="btn btn-sm btn-alt-primary" data-toggle="click-ripple" href="{{ route('finance.addInvoice') }}">Add Credit Invoice</a>
                    </div>
                    <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                            <thead>
                            <th></th>
                            <th>Reg. Number</th>
                            <th>Description</th>
                            <th>Invoice Number</th>
                            <th>Amount</th>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key => $invoice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invoice->reg_number }}</td>
                                    <td>{{ $invoice->description }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ number_format($invoice->deposit, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
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

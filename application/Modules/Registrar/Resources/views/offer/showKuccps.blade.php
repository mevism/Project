@extends('registrar::layouts.backend')


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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        GOVERNMENT SPONSORED
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Government Sponsored</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Government Sponsored
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

                <table id="example" class="table table-bordered table-striped js-dataTable-responsive fs-sm">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Code</th>
                            <th>Course</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Alternative Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kuccps as $item)
                        <tr>
                            <td>{{ $item->sname }} {{ $item->fname }} {{ $item->mname }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->kuccpsApplication->course_code }}</td>
                            <td>{{ $item->kuccpsApplication->course_name }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->alt_email }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                 </table>

            </div>
        </div>
        </div>
    </div>
    @endsection



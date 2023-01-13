@extends('cod::layouts.backend')
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

    $(document).ready(function() {
        $('#example1').DataTable( {
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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        {{ $pattern->class_code }} - {{ $pattern->semester }}
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">{{ $pattern->class_code }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Units
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

                    <div class="table table-responsive">
                        <h6 class="h6 fw-semibold fs-sm mb-2">Selected Semester Units</h6>
                        <table class="table table-sm table-borderless table-striped fs-sm" id="example">
                            <thead>
                            <th>#</th>
                            <th>Unit Code</th>
                            <th>Unit Name</th>
                            <th>Unit Type</th>
                            <th>Stage</th>
                            <th>Semester</th>
                            <th>Action</th>
                            </thead>
                        </table>

                        <h6 class="h6 fw-semibold fs-sm mb-2 mt-4">Course Units</h6>

                        <table class="table table-sm table-borderless table-striped fs-sm" id="example1">
                            <thead>
                            <th>#</th>
                            <th>Unit Code</th>
                            <th>Unit Name</th>
                            <th>Unit Type</th>
                            <th>Stage</th>
                            <th>Semester</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($units as $key => $unit)
                                        <tr>
                                            <td> {{ ++$key }} </td>
                                            <td> {{ $unit->course_unit_code }} </td>
                                            <td> {{ $unit->unit_name }} </td>
                                            <td> {{ $unit->type }} </td>
                                            <td> {{ $unit->stage }} </td>
                                            <td> {{ $unit->semester }} </td>
                                            <td>
                                                <a class="btn btn-sm btn-alt-success">add unit</a>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

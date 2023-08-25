@extends('cod::layouts.backend')

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

    {{--$(document).ready(function() {--}}
    {{--    $('#example').DataTable({--}}
    {{--        responsive: true,--}}
    {{--        serverSide: true,--}}
    {{--        ajax: "{{ route('department.jsonUnits') }}",--}}
    {{--        columns: [--}}
    {{--            { data: 'number', name: 'number'},--}}
    {{--            { data: 'unit_id', name: 'unit_id', visible: false }, // Hide the original ID column--}}
    {{--            { data: 'unit_code', name: 'unit_code' },--}}
    {{--            { data: 'unit_name', name: 'unit_name' },--}}
    {{--            { data: 'type', name: 'type' },--}}
    {{--            { data: 'department_name', name: 'department_name' }, // Use dot notation for related data--}}
    {{--            { data: 'total_exam', name: 'total_exam' },--}}
    {{--            { data: 'cat', name: 'cat'},--}}
    {{--            // { data: 'actions', name: 'actions', orderable: false, searchable: false }, // Action buttons--}}
    {{--            {--}}
    {{--                data: 'actions',--}}
    {{--                name: 'actions',--}}
    {{--                orderable: false,--}}
    {{--                searchable: false,--}}
    {{--                render: function(data, type, row) {--}}
    {{--                    var editUnitUrl = "{{ route('department.editUnit', ['unit' => ':unit_id']) }}";--}}
    {{--                    editUnitUrl = editUnitUrl.replace(':unit_id', row.unit_id);--}}
    {{--                    return '<a href="' + editUnitUrl + '" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Edit</a>';--}}
    {{--                }--}}
    {{--            }--}}
    {{--        ],--}}
    {{--        createdRow: function(row, data, dataIndex) {--}}
    {{--            // Get DataTable instance--}}
    {{--            var api = this.api();--}}

    {{--            // Set auto-incrementing numbering in the first column--}}
    {{--            var number = api.row(row).index() + 1;--}}
    {{--            $('td:eq(0)', row).html(number);--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}
    {{--$(document).ready(function() {--}}
    {{--    $('#example').DataTable({--}}
    {{--        responsive: true,--}}
    {{--        serverSide: true,--}}
    {{--        ajax: "{{ route('department.jsonUnits') }}",--}}
    {{--        columns: [--}}
    {{--            // { data: 'unit_id', name: 'unit_id', visible: false }, // Hide the original ID column--}}
    {{--            { data: 'number', name: 'number'},--}}
    {{--            { data: 'unit_code', name: 'unit_code' },--}}
    {{--            { data: 'unit_name', name: 'unit_name' },--}}
    {{--            { data: 'type', name: 'type' },--}}
    {{--            { data: 'department_name', name: 'department_name' },--}}
    {{--            { data: 'total_exam', name: 'total_exam' },--}}
    {{--            { data: 'cat', name: 'cat'},--}}
    {{--            {--}}
    {{--                data: 'actions',--}}
    {{--                name: 'actions',--}}
    {{--                orderable: false,--}}
    {{--                searchable: false,--}}
    {{--                render: function(data, type, row) {--}}
    {{--                    var editUnitUrl = "{{ route('department.editUnit', ['id' => ':unit_id']) }}";--}}
    {{--                    editUnitUrl = editUnitUrl.replace(':unit_id', row.unit_id);--}}
    {{--                    return '<a href="' + editUnitUrl + '" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Edit</a>';--}}
    {{--                }--}}
    {{--            }--}}
    {{--        ],--}}
    {{--        createdRow: function(row, data, dataIndex) {--}}
    {{--            var api = this.api();--}}
    {{--            var number = api.row(row).index() + 1;--}}
    {{--            $('td:eq(0)', row).html(number);--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

</script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        Department Units
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Departmental Units
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
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('department.addUnit') }}"> <i class="fa fa-plus-circle"></i> add unit</a>
                    </div>
                    <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Unit code</th>
                        <th>unit name</th>
                        <th>unit type</th>
                        <th>DEPARTMENT offering</th>
                        <th>WEIGHT </th>
                        <th>cat composition</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($units as $unit)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $unit->unit_code }} </td>
                                    <td> {{ $unit->unit_name }} </td>
                                    <td class="text-uppercase" nowrap="">
                                        @if($unit->type == 1)
                                            University Unit
                                        @elseif($unit->type == 2)
                                            Faculty Unit
                                        @else
                                            Department Unit
                                        @endif
                                    </td>
                                    <td> {{ $unit->DepartmentUnit->name }} </td>
                                    <td nowrap=""> {{ $unit->total_exam }} - {{ $unit->total_cat }} </td>
                                    <td nowrap=""> CAT: {{ $unit->cat }} - ASSIG.: {{ $unit->assignment }} - PRAC.: {{ $unit->practical }} </td>
                                    <td nowrap="">
                                        <a class="btn btn-sm btn-secondary" href="{{ route('department.editUnit', $unit->unit_id) }}"> <i class="fa fa-pencil"></i> edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
{{--                    {{ $units->links('pagination::bootstrap-5') }}--}}
                </div>
            </div>
        </div>
    </div>


@endsection

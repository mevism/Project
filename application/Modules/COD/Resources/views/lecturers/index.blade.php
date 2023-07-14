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
</script>

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-1">
                    <h5 class="h6 fw-bold mb-0">
                        DEPARTMENTAL LECTURERS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All lecturers
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
                    <table id="example" class="table table-bordered table-sm table-striped fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Staff number </th>
                        <th>Staff name </th>
                        <th>Gender </th>
                        <th>Terms</th>
                        <th>Roles</th>
                        <th>Phone Number</th>
                        <th>Email Address </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($lecturers as $key => $lecturer)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $lecturer->staff_number }} </td>
                                <td> {{ $lecturer->title }} {{ $lecturer->last_name }} {{ $lecturer->first_name }} {{ $lecturer->middle_name }}</td>
                                <td> {{ $lecturer->gender }} </td>
                                <td> {{ $lecturer->employment_terms }} </td>
                                <td>
                                    @foreach($lecturer->Users->roles as $role)
                                        {{ $role->name }}<br>
                                    @endforeach
                                </td>
                                <td> {{ $lecturer->phone_number }} </td>
                                <td> {{ $lecturer->office_email }} </td>
                                <td>
                                <a class="btn btn-sm btn-outline-secondary" disabled>view</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

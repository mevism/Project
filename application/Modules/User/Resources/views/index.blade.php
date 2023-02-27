@extends('registrar::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                        SYSTEM USERS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Users</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Manage Users
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
{{--                        <a class="btn  btn-alt-primary btn-sm" href="{{ route('admin.addNewUser') }}">Add User</a>--}}
                        <a type="button" class="btn btn-sm btn-alt-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Add User</a>
                    </div>
                        @csrf
                        <table id="example" class="table table-md table-striped table-striped-columns table-bordered table-vcenter fs-sm">
                                <thead>
                                <th>#</th>
                                <th nowrap="">Staff No.</th>
                                <th nowrap="">Name</th>
                                <th nowrap="">Official Email</th>
                                <th nowrap="">Division</th>
                                <th nowrap="">Role</th>
                                <th nowrap="">Manage</th>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                        <tr>
                                            <td> {{ ++$key }} </td>
                                            <td> {{ $user->staff_number }} </td>
                                            <td> {{ $user->title }} {{  $user->last_name }} {{  $user->first_name }} {{  $user->middle_name }} </td>
                                            <td> {{ $user->office_email }} </td>
                                            <td class="text-uppercase">
                                                @foreach($user->employmentDivision as $key => $division)
                                                    <p>
                                                        {{ $division->name }}
                                                    </p>
                                                @endforeach
                                            </td>
                                            <td nowrap="">
                                                @foreach($user->roles as $key => $role)
                                                    <p>{{ ++$key }}. {{ $role->name }}</p>
                                                @endforeach
                                            </td>
                                            <td nowrap="">
                                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.addUserRole', ['id' => Crypt::encrypt($user->id)]) }}">roles</a>
                                                <a class="btn btn-sm btn-outline-primary">permissions</a>
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
<div class="modal " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">FETCH USERS FROM TUMHRMS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="get" action="{{ route('admin.addNewUser') }}">
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-10 mb-3">
                            <select class="form-control" id="search" name="search" style="width: 100% !important;">
                                <option SELECTED DISABLED class="text-center"> -- Search staff by staff/ID number -- </option>
                                @foreach($staff as $user)
                                    <option value="{{ $user->STAFFNO }}">{{ $user->STAFFNO }} - {{ $user->STAFFNAME }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-md btn-alt-primary col-md-7">NEXT STEPS</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#search').select2({
        dropdownParent: $(".modal")
    });

</script>

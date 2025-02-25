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
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h6 class="h6 fw-bold mb-0">
                DEPARTMENTS
            </h6>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item text-uppercase">
                        <a class="link-fx" href="javascript:void(0)">Departments</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase" aria-current="page">
                        View departments
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Dynamic Table Responsive -->
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          <div class="row">
            <div class="col-12 table-responsive">
                <span class="d-flex justify-content-end m-2">
                <a class="btn btn-alt-info btn-sm" href="{{ route('courses.addDepartment') }}">Create</a>
                </span>
          <table id="example" class="table table-sm table-bordered table-striped fs-sm">
            <thead>

              <tr>
                <th>#</th>
                <th>SCHOOL</th>
                <th>DEPARTMENT NAME</th>
                <th nowrap="">DEPT CODE</th>
                <th>DIVISION</th>
                <th>HISTORY</th>
                <th>Action</th>
              </tr>

            </thead>
            <tbody>
              @foreach ($data as $key => $department)
              <tr>
                <td> {{ ++$key }} </td>
                <td> {{ $department->deptSchool->name }}</td>
                <td> {{ $department->name }}</td>
                <td> {{ $department->dept_code }} </td>
                  <td> {{ strtoupper($department->deptDivision->name) }} </td>
                  <td>
                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.departmentPreview', $department->department_id)}}"> View </a>
                  </td>
                <td nowrap>
                  <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editDepartment', $department->department_id) }}">  edit <i class="fa fa-pencil"></i> </a>
{{--                  <a class="btn btn-sm btn-alt-danger" onclick="return confirm('Are you sure you want to delete this department ?')"  href="{{ route('courses.destroyDepartment', $department->id) }}">delete</a>--}}
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        </div>
      </div>
      <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->
@endsection

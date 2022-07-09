@extends('layouts.backend')

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
          order: [[2, 'asc']],
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
                    CLASSES
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Classes</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        View classes
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
          <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
            <span class="d-flex justify-content-end">
                <a class="btn btn-alt-info btn-sm" href="{{ route('courses.addClasses') }}">Create</a>
            </span><br>
            <thead>
                <th>Classes</th>
                <th>Attendance</th>
                <th>Course</th>
                <th>Action</th>
            </thead>
            <tbody>
              @foreach ($data as $class)
              <tr>

                <td class="fw-semibold fs-sm text-uppercase">{{ $class->name }}</td>
                <td class="fw-semibold fs-sm">{{ $class->attendance_id }}</td>
                <td style="text-transform: uppercase"class="fw-semibold fs-sm">{{ $class->course_id }}</td>
                <td>
                  <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editClasses', $class->id) }}">edit</a>
                <a class="btn btn-sm btn-alt-danger" href="{{ route('courses.destroyClasses', $class->id) }}">delete</a>
              </td>
              </tr>
              @endforeach

            </tbody>
          </table>
          {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
      </div>
      <!-- Dynamic Table Responsive -->
    </div>
@endsection
{{--<script>--}}
{{--  $(document).ready(function() {--}}
{{--      $('#example').DataTable( {--}}
{{--          responsive: true,--}}
{{--          order: [[2, 'asc']],--}}
{{--          rowGroup: {--}}
{{--              dataSrc: 2--}}
{{--          }--}}
{{--      } );--}}
{{--  } );--}}
{{--</script>--}}

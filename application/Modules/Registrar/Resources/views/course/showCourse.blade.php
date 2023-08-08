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
                <h6 class="h6 fw-bold mb-0">
                    COURSES
                </h6>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item text-uppercase">
                        <a class="link-fx" href="javascript:void(0)">Courses</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase" aria-current="page">
                        View courses
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="block block-rounded">

      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-12 table-responsive">
        <table id="example" class="table table-bordered table-striped table-sm fs-sm">
          <span class="d-flex justify-content-end">
            <a class="btn btn-alt-info btn-sm m-2" href="{{ route('courses.addCourse') }}">Create</a>
        </span><br>
          <thead>
            <tr>
              <th>  #     </th>
              <th>  Department NAME </th>
              <th> Course NAME</th>
              <th>history</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $courses)
            <tr>
              <td style="text-transform: uppercase" >{{ ++$key }} </td>
              <td style="text-transform: uppercase" >{{ $courses->getCourseDept->name }}</td>
              <td style="text-transform: uppercase" >{{ $courses->course_name }}</td>
              <td>
                <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.coursePreview', $courses->course_id)}}"> View </a>
              </td>
              <td nowrap="">
                <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editCourse', $courses->course_id ) }}">edit</a>
{{--                <a class="btn btn-sm btn-alt-danger" onclick="return confirm('Are you sure you want to delete this course ?')" href="{{ route('courses.destroyCourse', $courses->id) }}">delete</a>--}}
                <a class="btn btn-sm btn-alt-primary" href="{{ route('courses.syllabus',['course_id'=> Crypt::encrypt($courses->course_id)]) }}">syllabus</a>
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

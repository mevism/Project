
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
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                      COURSES AVAILABLE
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            View selected intake
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
              <table id="example" class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
                <span class="d-flex justify-content-end">
                  <a class="btn btn-alt-info btn-sm" href="{{ route('courses.showIntake') }}">Back</a>
              </span><br>
                <thead>

                  <tr>
                    <th>Course Code</th>
                    <th>Courses</th>
                    <th>Department</th>
                    <th>Period</th>
                    <th>View</th>
                  </tr>

                </thead>
                <tbody>
                    @foreach ($courses as $course)

                         @foreach ($course as $item)
                         <tr>
                            <td>{{ $item->course_code }}</td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item->department_id }}</td>
                            <td>{{ $item->course_duration }}</td>
                           <td><a href="{{ route('courses.viewCourse',$item->id) }}" class="btn btn-sm btn-alt-secondary" data-toggle="click-ripple">view</a></td>
{{--                            <td><a href="" class="btn btn-sm btn-alt-info" data-toggle="click-ripple">edit</a></td>--}}
{{--                            <td><a href="{{  route('courses.destroyCoursesAvailable', $item->id)  }}" class="btn btn-sm btn-alt-danger" data-toggle="click-ripple">delete</a></td>--}}

                         </tr>
                         @endforeach

                     @endforeach

                </tbody>
              </table>
                </div>
            </div>
          </div>
          <!-- Dynamic Table Responsive -->
        </div>
@endsection

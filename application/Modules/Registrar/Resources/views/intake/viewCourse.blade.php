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
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        COURSES DETAILS
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
              <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                <span class="d-flex justify-content-end">
              
                  <thead>                    
                  <tr>
                    <th>Course Code</th>
                    <th>Courses</th>
                    <th>Department</th>
                    <th>Level</th>
                    <th>Period</th>
                    <th>Requirements</th>
                    <th>Subject1</th>
                    <th>Subject2</th>
                    <th>Subject3</th>
                    <th>Subject4</th>
                  </tr>
                  
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    
                         @foreach ($course as $item)
                         <tr>
                            <td>{{ $item->course_code }}</td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item->department_id }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ $item->course_duration }}</td>
                            <td>{{ $item->course_requirements }}</td>
                            <td>{{ $item->subject1 }}</td>
                            <td>{{ $item->subject2 }}</td>
                            <td>{{ $item->subject3 }}</td>
                            <td>{{ $item->subject4 }}</td>
                    
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

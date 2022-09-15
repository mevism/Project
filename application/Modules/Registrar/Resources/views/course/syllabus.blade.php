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
          order: [[1, 'asc']],
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
                <h5 class="h5 fw-bold mb-0">
                    UNITS
                </h5>
            </div>
       
        </div>
    </div>
</div>

<div class="block block-rounded">

  <div class="block-content block-content-full">
    <div class="row">
      <div class="col-12">
    <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
      <span class="d-flex justify-content-end">
        <a class="btn btn-alt-info btn-sm" href="{{ route('courses.addCourse') }}">Create</a>
    </span><br>
      <thead>
        <tr>
          <th></th>
          <th> Course Code </th>
          <th> Unit Code</th>
          <th> Unit Name</th>
          <th> Year of Study</th>
          <th> Semester</th>
          <th> Unit Type</th>
          {{-- <th>Action</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($units as $key => $unit)
        <tr>
          <td> {{ ++$key }} </td>
          <td style="text-transform: uppercase" >{{ $unit->course_code }}</td>
          <td style="text-transform: uppercase" >{{ $unit->course_unit_code }}</td>
          <td style="text-transform: uppercase" >{{ $unit->unit_name }}</td>
          <td style="text-transform: uppercase" >{{ $unit->stage }}</td>
          <td style="text-transform: uppercase" >{{ $unit->semester }}</td>
          <td style="text-transform: uppercase" >{{ $unit->type }}</td>
         
        </tr>
        @endforeach
      </tbody>

    </table>
    </div>
  </div>
</div>
<!-- Dynamic Table Responsive -->
</div>
@endsection


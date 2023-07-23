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
                <div class="flex-grow-1">
                    <h6 class="block-title">
                        HISTORY OF  
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course</a>
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
                    <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <span class="d-flex justify-content-end">
                            <a class="btn btn-alt-info btn-sm" href="{{ route('courses.showCourse') }}">Back</a>
                        </span><br>
                        <thead>
                            <th>#</th>
                            <th>department Name</th>
                            <th>course NAME </th>
                            <th>course code</th>
                            <th>Created at</th>
                        </thead>
                        <tbody>@foreach ($data as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->coursehistorydept->name}}</td>
                                <td>{{ $data->course_name }}</td>
                                <td>{{ $data->course_code }}</td>
                                <td>{{ $data->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
    
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
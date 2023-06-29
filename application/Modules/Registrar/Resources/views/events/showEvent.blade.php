@extends('registrar::layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <div class="h6 fw-bold mb-0">
               EVENTS
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Events</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        View Events
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
      <div class="block block-rounded">

        <div class="block-content block-content-full">
          <div class="row">
            <div class="table-responsive col-12">
          <table id="example" class="table table-bordered table-striped table-sm fs-sm">
            <span class="d-flex justify-content-end">
                <a class="btn btn-alt-info btn-sm" href="{{ route('courses.addEvent') }}">Create</a>
            </span><br>
            <thead>
                <th>#</th>
                <th>NAME</th>
                <th>ACTION</th>
            </thead>
            <tbody>
              @foreach ($events as $key => $item)
              <tr>
                 <td>{{ ++$key }}</td>
                 <td>{{ $item->name }}</td>
                 <td>
                    <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editEvent', $item->id) }}">edit</a>
                    <a class="btn btn-sm btn-alt-danger" onclick="return confirm('Are you sure you want to delete this event ?')" href="{{ route('courses.destroyEvent', $item->id) }}">delete</a>
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
@endsection

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

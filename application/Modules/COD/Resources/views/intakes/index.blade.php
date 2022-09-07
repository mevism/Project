@extends('cod::layouts.backend')
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
            order: [[1, 'desc']],
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
                    <h5 class="h5 fw-bold mb-0">
                        Intakes
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Intakes
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
                    <table id="example" class="table table-bordered table-striped fs-sm">
                        <thead>
                        <th>#</th>
                            <th>Intakes</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($intakes as $intake)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-transform: uppercase" class="fw-semibold fs-sm">{{ Carbon\carbon::parse($intake->intake_from)->format('M')}} - {{ Carbon\carbon::parse($intake->intake_to)->format('M Y') }}</td>
                                <td>
                                    @if ($intake->status === 0)
                                        <span class="badge bg-primary">Intake Pending</span>
                                    @endif
                                    @if ($intake->status === 1)
                                          <span class="badge bg-success">Intake Ongoing</span>
                                    @endif
                                    @if ($intake->status === 2)
                                        <span  class="badge bg-warning">Intake Closed</span>
                                    @endif
                                    @if ($intake->status === 3)
                                        <span  class="badge bg-danger">Intake Suspended</span>
                                    @endif
                                </td>
                                <td>
                                    @if($intake->status === 0 )
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('department.intakeCourses', $intake->id) }}">Add courses</a>
                                    @else
                                    <a class="btn btn-sm btn-alt-secondary" onclick="return confirm('Are you sure you want to delete this intake ?')" href="{{ route('courses.destroyIntake', $intake->id) }}">View details</a>
                                    @endif
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

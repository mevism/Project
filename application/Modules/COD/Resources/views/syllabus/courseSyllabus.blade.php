@extends('cod::layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                       {{ $course->course_code }} Syllabus
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course Syllabus</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Syllabus Version
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('department.addSyllabusVersion', $course->course_id) }}"><i class="fa fa-plus-circle"></i> Add Version</a>
                    </div>
                    <table id="example" class="table table-responsive table-sm table-striped table-bordered fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Syllabus Version</th>
                        <th> Action </th>
                        </thead>
                        <tbody>
                        @foreach($versions as $version)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $version->syllabus_name }} </td>
                                <td nowrap="">
                                    <a class="btn btn-sm btn-alt-primary" href="{{ route('department.viewSyllabusUnits', $version->syllabus_id) }}"> add/edit syllabus </a> |
                                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('department.completeCourseSyllabus', ['course' => $course->course_id, 'version' => $version->syllabus_id]) }}"> view syllabus </a>
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

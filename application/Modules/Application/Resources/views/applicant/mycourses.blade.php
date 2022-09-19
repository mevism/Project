
@extends('application::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-1">
                        Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                        @if(count($courses)>0)
                            <thead>
                            <tr>
                                <th>Department</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->courses->getCourseDept->name }}</td>
                                    <td>{{ $course->courses->course_name }}</td>
                                    <td nowrap="">
                                        @if($course->registrar_status === 3 && $course->cod_status === 1)
                                        <a class="btn btn-sm btn-alt-success" target="_top" href="{{ route('application.download', $course->id) }}"><i class="fa fa-file-pdf"></i> download</a>
                                        <a class="btn btn-sm btn-alt-info" data-toggle="click-ripple" href="{{ route('application.uploadDocuments', $course->id) }}"><i class="fa fa-file-upload"></i> upload docs</a>
                                        @elseif($course->registrar_status === NULL && $course->finance_status === NULL)
                                        <a class="btn btn-sm btn-alt-info" href="{{ route('application.edit', $course->id) }}">
                                            <i class="fa fa-pen-to-square"></i> update</a>
                                        @elseif($course->registrar_status === 1 && $course->cod_status === 2)
                                            <a class="btn btn-sm btn-alt-danger" href="#">
                                                <i class="fa fa-ban"></i> rejected</a>
                                        @else
                                            <a class="btn btn-sm btn-alt-secondary" href="{{ route('application.progress', $course->id) }}"> <i class="fa fa-spinner"></i> in progress</a>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <small class="text-center text-muted"> You have not submitted any applications</small>
                        @endif
                    </table>
        </div>
    </div>
@endsection
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

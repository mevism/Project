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
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                    <div class="flex-grow-0">
                        <h5 class="h5 fw-bold mb-0">
                            Courses
                        </h5>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">Courses</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                All Courses
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="block block-rounded">
                    <div class="block-content block-content-full">
    <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
        <thead>
        <tr>
            <th>Course Name</th>
            <th>Department</th>
            <th>Duration</th>
            <th>Intake</th>
            <th>View</th>
            <th class="d-none d-sm-table-cell">Apply</th>
        </tr>
        </thead>
        <tbody>
        @foreach($courses as $course)
            @foreach($course as $item)

{{--                @dd($item)--}}
                <tr>
                    <td> {{ $item->mainCourses->course_name }}</td>
                    <td> {{ $item->mainCourses->department_id }}</td>
                    <td> {{ $item->mainCourses->course_duration }}</td>
                    <td nowrap="">
                        {{ Carbon\carbon::parse($item->openCourse->intake_from)->format('M')}} - {{ Carbon\carbon::parse($item->openCourse->intake_to)->format('M Y') }}
                    </td>
                    <td nowrap=""> <a class="btn btn-sm btn-alt-secondary" href="{{ route('application.viewOne', $item->id) }}">View </a> </td>
                    <td nowrap=""> <a class="btn btn-sm btn-alt-info" href="{{ route('application.apply', $item->id) }}">Apply now </a> </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
  </div>
        </div>
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
@endsection


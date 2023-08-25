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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center fs-sm">
                <h6 class="h6 fw-bold mb-0">
                    SEMESTER FEE
                </h6>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx text-uppercase" href="javascript:void(0)">Semester Fee</a>
                        </li>
                        <li class="breadcrumb-item text-uppercase" aria-current="page">
                            View Semester Fee
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Dynamic Table Responsive -->
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="table-responsive col-12">
                    <div class="d-flex justify-content-end m-2">
                        <a class="btn btn-alt-primary btn-sm" href="{{ route('courses.semFee', $course->course_id) }}"><i class="fa fa-plus-circle"></i> add structure</a>
                    </div>
                    <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>COURSE CODE</th>
                            <th>COURSE NAME</th>
                            <th>MODE OF STUDY</th>
                            <th>VERSION</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeSstructures as $attendance => $fees)
                            @foreach($fees as $version => $item)
                                <tr>
                                    <td> {{ $loop->iteration  }} </td>
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>
                                        @if($attendance == 1)
                                            S-FT
                                        @elseif($attendance == 2)
                                            J-FT
                                        @elseif($attendance == 3)
                                            S-PT
                                        @else
                                            OTHERS
                                        @endif
                                    </td>
                                    <td>{{ $version }}</td>
                                    <td nowrap="">
                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.viewSemFee', base64_encode($course->course_code.':'.$attendance.':'.$version)) }}"> <i class="fa fa-eye"></i> view</a>
                                    </td>
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


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
                        Complete {{ $course->course_code }} Syllabus
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course Syllabus</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Complete Syllabus Version
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
                    <table id="example" class="table table-sm table-striped table-bordered fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Stage</th>
                        <th> Semester Units</th>
                        </thead>
                        <tbody>
                        @foreach ($stages as $stage => $semester)
                            @php
                                $splitStage = explode('.', $stage);
                            @endphp
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> <b> Year {{ $splitStage[0] }} Semester {{ $splitStage[1] }}</b></td>
                                <td>
                                    <ol>
                                        @foreach ($semester as $unit)
                                            <div class="row">
                                                <div class="col-md-3"> {{ $loop->iteration }}. {{ $unit->unit_code }}</div> <div class="col-md-6"> {{ $unit->SyllabusUnit->unit_name }} @if($unit->option != $course->course_id)
                                                ( {{ \Modules\COD\Entities\CourseOptions::where('option_id', $unit->option)->first()->option_name }} ) @endif </div> <div class="col-md-3"> {{ $unit->type }} </div>
                                            </div>
                                        @endforeach
                                    </ol>
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

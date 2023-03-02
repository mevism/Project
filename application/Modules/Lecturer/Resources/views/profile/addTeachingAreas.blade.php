@extends('lecturer::layouts.backend')
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

    $(document).ready(function() {
        $('#example1').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    $(document).ready(function() {
        $('#example2').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    $(document).ready(function() {
        $('#example3').DataTable( {
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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Add Teaching Areas
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Teaching Areas
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-alt d-flex justify-content-between" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="btabs-alt-static-grad-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-grad" role="tab" aria-controls="btabs-alt-static-grad" aria-selected="true">Post Graduate Courses</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="btabs-alt-static-under-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-under" role="tab" aria-controls="btabs-alt-static-under" aria-selected="false">Degree Courses</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="btabs-alt-static-dip-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-dip" role="tab" aria-controls="btabs-alt-static-dip" aria-selected="true">Diploma Courses</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="btabs-alt-static-cert-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-cert" role="tab" aria-controls="btabs-alt-static-cert" aria-selected="false">Certificate Courses</button>
                    </li>

                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-left show active" id="btabs-alt-static-grad" role="tabpanel" aria-labelledby="btabs-alt-static-grad-tab">
                        <form method="post" action="{{ route('lecturer.storeTeachingAreas') }}">
                            <table id="example" class="table table-bordered table-striped js-dataTable-responsive">
                                <thead>
                                <th>#</th>
                                <th>Course</th>
                                <th>UNIT CODE</th>
                                <th>UNIT NAME</th>
                                <th>SELECTED</th>
                                </thead>
                                <tbody>
                            @foreach($units as $allunit)
                                @foreach($allunit as $key => $unit)
                                    @if($unit->courseLevel->level >= 4)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td> {{ $unit->course_code }} </td>
                                            <td> {{ $unit->course_unit_code }} </td>
                                            <td>{{ $unit->unit_name }}</td>
                                            <td>
                                                <input type="checkbox" name="units[]" value="{{ $unit->id }}" class="form-check-inline">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade fade-left show" id="btabs-alt-static-under" role="tabpanel" aria-labelledby="btabs-alt-static-under-tab">
                            <table id="example1" class="table table-bordered table-striped js-dataTable-responsive">
                                <thead>
                                <th>#</th>
                                <th>Course</th>
                                <th>UNIT CODE</th>
                                <th>UNIT NAME</th>
                                <th>SELECTED</th>
                                </thead>
                                <tbody>
                                @foreach($units as $allunit)
                                    @foreach($allunit as $key => $unit)
                                        @if($unit->courseLevel->level == 3)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td> {{ $unit->course_code }} </td>
                                                <td> {{ $unit->course_unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    <input type="checkbox" name="units[]" value="{{ $unit->id }}" class="form-check-inline">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade fade-left show" id="btabs-alt-static-dip" role="tabpanel" aria-labelledby="btabs-alt-static-dip-tab">
                            <table id="example2" class="table table-bordered table-striped js-dataTable-responsive">
                                <thead>
                                <th>#</th>
                                <th>Course</th>
                                <th>UNIT CODE</th>
                                <th>UNIT NAME</th>
                                <th>SELECTED</th>
                                </thead>
                                <tbody>
                                @foreach($units as $allunit)
                                    @foreach($allunit as $key => $unit)
                                        @if($unit->courseLevel->level == 2)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td> {{ $unit->course_code }} </td>
                                                <td> {{ $unit->course_unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    <input type="checkbox" name="units[]" value="{{ $unit->id }}" class="form-check-inline">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade fade-left show" id="btabs-alt-static-cert" role="tabpanel" aria-labelledby="btabs-alt-static-cert-tab">
                            <table id="example3" class="table table-bordered table-striped js-dataTable-responsive">
                                <thead>
                                <th>#</th>
                                <th>Course</th>
                                <th>UNIT CODE</th>
                                <th>UNIT NAME</th>
                                <th>SELECTED</th>
                                </thead>
                                <tbody>
                                @foreach($units as $allunit)
                                    @foreach($allunit as $key => $unit)
                                        @if($unit->courseLevel->level == 1)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td> {{ $unit->course_code }} </td>
                                                <td> {{ $unit->course_unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    <input type="checkbox" name="units[]" value="{{ $unit->id }}" class="form-check-inline">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

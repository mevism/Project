@extends('student::layouts.backend')

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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        SEMESTER REGISTRATION
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}"> student progress </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Registration history
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="d-flex justify-content-end m-2">
                <a class="btn btn-sm btn-alt-primary m-2" href="{{ route('student.requestRegistration') }}">Create request</a>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-responsive-sm table-striped table-borderless fs-sm">
                    <thead>
                        <th>#</th>
                        <th>Academic Year</th>
                        <th>Academic Semester</th>
                        <th>Stage</th>
                        <th>Semester</th>
                        <th>Season </th>
                        <th>Registration</th>
                        <th>Sem Units</th>
                    </thead>
                    <tbody>
                        @foreach($reg as $key => $register)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ \Carbon\Carbon::parse($register->NominalIntake->academicYear->year_start)->format('Y').'/'.\Carbon\Carbon::parse($register->NominalIntake->academicYear->year_end)->format('Y') }} </td>
                                <td> {{ strtoupper(\Carbon\Carbon::parse($register->NominalIntake->intake_from)->format('M').'/'.\Carbon\Carbon::parse($register->NominalIntake->intake_to)->format('M')) }} </td>
                                <td> {{ $register->year_study }} </td>
                                <td> {{ $register->semester_study }} </td>
                                <td> {{ $register->patternRoll->season }} </td>
                                <td>
                                    @if($register->activation == 0)
                                        <span class="text-info"> Pending </span>
                                    @elseif($register->registration == 1)
                                        <span class="text-success"> Successful </span>
                                    @else
                                        <span class="text-danger"> Unsuccessful</span>
                                    @endif
                                </td>
                                <td nowrap="">
                                    <a class="btn btn-sm btn-outline-info" href="{{ route('student.viewSemesterUnits', $register->nominal_id) }}">View units</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

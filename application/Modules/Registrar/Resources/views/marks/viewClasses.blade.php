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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                       EXAM MARKS PER CLASSES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Schools</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            exam marks
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
                            <span class="d-flex justify-content-end m-2">
                                <a class="btn btn-alt-info btn-sm" href="{{ route('courses.schoolExamMarks') }}">Approval Page</a>
                            </span>
                            <thead>
                                <th>#</th>
                                <th>Class Code</th>
                                <th>department</th>
                                <th>Academic year</th>
                                <th>academic semester</th>
                                <th>Action</th>
                            </thead>
                            <tbody>                                
                                @foreach($exams as $class => $exam)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $class }} </td>
                                        <td>
                                            @foreach($departs as $deptCode)
                                            @if($dept == $deptCode->id )

                                            {{ $deptCode->dept_code }}

                                            @endif
                                        @endforeach
                                        </td>
                                        <td>{{ $year }}</td>
                                        <td>{{ $sem }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('courses.viewStudents', ['class' => Crypt::encrypt($class), 'sem' => Crypt::encrypt($sem), 'id' => Crypt::encrypt($id), 'year' => Crypt::encrypt($year)]) }}">viewStudents </a>
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

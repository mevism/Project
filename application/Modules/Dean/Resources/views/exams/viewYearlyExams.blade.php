@extends('dean::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

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
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0">
                        PREPARE SEMESTER EXAMS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">School</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Exams
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
                    <table id="example" class="table table-borderless table-sm table-striped fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Academic Year </th>
                        <th>Academic Semester </th>
                        <th>Department </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($semesters as $sem => $examSemester)
                            @foreach($examSemester as $dept => $deptSemesters)
                                @foreach($deptSemesters as $semester)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $semester->academic_year }} </td>
                                        <td class="text-uppercase"> {{ $semester->academic_semester }} </td>
                                        <td> {{ \Modules\Registrar\Entities\Department::where('department_id', $dept)->first()->name }} </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('dean.exams', $semester->exam_approval_id) }}"> View </a>
                                            <a class="btn btn-sm btn-outline-info" href="#"> Download </a>
                                            @if($semester->dean_status === 0 && $semester->registar_status == null)
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('dean.approveExamMarks', $semester->exam_approval_id) }}"> Approve </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $semester->exam_approval_id }}"> Decline</button>
                                            @elseif($semester->dean_status === 1 && $semester->registrar_status === null || $semester->registrar_status == 2)
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $semester->exam_approval_id }}"> Decline</button>
                                                <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to submit this exam for Senate approval?')" href="{{ route('dean.submitExamMarks', $semester->exam_approval_id) }}"> Submit </a>
                                            @elseif($semester->dean_status == 2 && $semester->registar_status == null && $semester->cod_status == 1)
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('dean.approveExamMarks', $semester->exam_approval_id) }}"> Approve </a>
                                                <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to reverse this exam to COD?')" href="{{ route('dean.revertExamMarks', $semester->exam_approval_id) }}"> Revert </a>
                                            @elseif($semester->dean_status == 2 && $semester->registar_status == null && $semester->cod_status == 3 || $semester->cod_status == 2)
                                                <a class="btn btn-sm btn-outline-warning disabled" href="#"> Awaiting for corrections </a>
                                            @elseif($semester->dean_status === null && $semester->cod_status === 1 || $semester->cod_status === 2)
                                                <a class="disabled btn btn-sm btn-outline-primary">Pending Submission</a>
                                            @elseif($semester->cod_status === 1 && $semester->dean_status === 1 && $semester->registrar_status === 0)
                                                <a class="btn btn-sm btn-outline-success disabled">Awaiting Senate Approval</a>
                                            @elseif($semester->dean_status === 3 && $semester->cod_status == 1 && $semester->status === null)
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('dean.approveExamMarks', $semester->exam_approval_id) }}"> Approve </a>
                                                <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to reverse this exam to COD?')" href="{{ route('dean.revertExamMarks', $semester->exam_approval_id) }}"> Revert </a>
                                                <a type="button" class="btn-link text-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $semester->exam_approval_id }}">
                                                    Why rejected?
                                                </a>
                                            @elseif($semester->cod_status == 3 && $semester->dean_status == 3 && $semester->registrar_status == 2)
                                                <a class="btn btn-sm btn-outline-warning disabled" href="#"> Awaiting for corrections </a>
                                            @elseif($semester->cod_status == 1 && $semester->dean_status == 1 && $semester->registrar_status == 1 && $semester->status == 1)
                                            @if($semester->status == 1 && $semester->DepartmentalResults->first()->status == 1)
                                                <a class="btn btn-sm btn-outline-success disabled">Exam Results Published</a>
                                                @else
                                                    <a class="btn btn-sm btn-outline-success" href="{{ route('dean.publishResults', $semester->exam_approval_id) }}"> Publish Results </a>
                                                @endif
                                            @endif
                                        </td>
                                        <div class="modal fade" id="staticBackdrop-{{ $semester->exam_approval_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title fs-8" id="staticBackdropLabel">REASONS FOR DECLINING</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <form method="POST" action="{{ route('dean.declineExams', $semester->exam_approval_id) }}">
                                                                @csrf
                                                                <div class="mb-4 form-floating">
                                                                    <textarea name="remarks" class="form-control" placeholder="hey" rows="5" style="height: 150px !important;"></textarea>
                                                                    <label>EXPLANATION FOR DECLINING SELECTED EXAM MARKS</label>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-outline-danger col-7">Decline Results</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="staticBackdrop{{$semester->exam_approval_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title fs-7" id="staticBackdropLabel">REASON(S) FOR DECLINING</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <h6>Senate Remarks : </h6>
                                                            <p> {{ $semester->registrar_remarks }} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

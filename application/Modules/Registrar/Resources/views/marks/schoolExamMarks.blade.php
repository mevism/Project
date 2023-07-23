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
                      SCHOOL EXAMINATIONS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">SCHOOL</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            SCHOOL EXAMINATIONS
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
                                <th>Academic Year</th>
                                <th>Academic Semester</th>
                                <th>School</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                               @foreach($schools as $schID => $schExams)
                                   @foreach($schExams as $school)
                                       <tr>
                                           <td> {{ $loop->iteration }}</td>
                                           <td> {{ $year }} </td>
                                           <td class="text-uppercase"> {{ $semester }} </td>
                                           <td> {{ \Modules\Registrar\Entities\School::where('school_id', $schID)->first()->name }} </td>
                                           <td>
                                               <a class="btn btn-sm btn-outline-secondary"  href="{{ route('courses.viewExamMarks',$school->exam_approval_id) }}">View</a>
                                               <a class="btn btn-sm btn-outline-info"  href="{{ route('courses.downloadExamMarks',$school->exam_approval_id) }}">Download</a>
                                               @if($school->registrar_status == 0 && $school->status == null)
                                                   <a class="btn btn-sm btn-outline-success"  href="{{ route('courses.approveExamMarks', $school->exam_approval_id) }}">Approve</a>
                                                   <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $school->exam_approval_id}}"> Decline </a>
                                               @elseif($school->dean_status == 1 && $school->registrar_status == 1 && $school->status == null)
                                                   <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $school->exam_approval_id}}"> Decline </a>
                                                   <a class="btn btn-sm btn-outline-success"  href="{{ route('courses.submitExamMarks', $school->exam_approval_id) }}">Submit</a>
                                               @elseif($school->registrar_status == 2 && $school->status == null)
                                                   <a class="btn btn-sm btn-outline-success"  href="{{ route('courses.approveExamMarks', $school->exam_approval_id) }}">Approve</a>
                                                   <a class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to reverse these results')" href="{{ route('courses.revertExamMarks', $school->exam_approval_id) }}">Revert</a>
                                               @elseif($school->dean_status == 3 && $school->registrar_status == 2 && $school->status == null)
                                                   <a class="btn btn-sm btn-outline-warning disabled" >Waiting Corrections</a>
                                               @elseif($school->dean_status !== null && $school->status == null)
                                                   <a class="btn btn-sm btn-outline-warning disabled" >Waiting Corrections</a>
                                               @elseif($school->dean_status === 1 && $school->cod_status === 1 && $school->registrar_status === 1 && $school->status === 1)
                                                   @if($school->registrar_status === 1 && $school->status === 1 && $school->SchoolDeparmentalExams->first()->status === 1)
                                                      <a class="btn btn-sm btn-outline-success disabled">Exam Results Published</a>
                                                   @else
                                                   <a class="btn btn-sm btn-outline-success disabled"> Awaiting Publishing</a>
                                                    @endif
                                               @endif
                                               <div class="modal fade" id="staticBackdrop-{{ $school->exam_approval_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                   <div class="modal-dialog modal-lg">
                                                       <div class="modal-content">
                                                           <div class="modal-header">
                                                               <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                                                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                           </div>
                                                           <div class="modal-body">
                                                               <form method="POST" action="{{ route('courses.declineExamMarks', $school->exam_approval_id) }}">
                                                                   @csrf
                                                                   <div class="d-flex justify-content-center mb-4">
                                                                       <div class="col-md-11">
                                                                           <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>

                                                                       </div>
                                                                   </div>
                                                                   <div class="d-flex justify-content-center">
                                                                       <button type="submit" class="btn btn-outline-success col-md-5">Submit Remarks</button>
                                                                   </div>
                                                               </form>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </td>

                                       </tr>
                                   @endforeach
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('dean::layouts.backend')
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
                        ACADEMIC YEAR EXAMINATION
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Examination
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
                       <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped fs-sm">
                            <thead>
                                <th>#</th>
                                <th>Department</th>
                                <th>Academic Year</th>
                                <th>Academic Semester</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($departments as $exams)                                
                                    @foreach($exams as $dept =>  $exam)
                                        <tr>
                                            <td>  {{ $loop->iteration }}</td>
                                            <td>                                                
                                                @foreach($departs as $deptCode)
                                                @if($dept == $deptCode->id )

                                                {{ $deptCode->dept_code }}

                                                @endif
                                            @endforeach
                                            </td>
                                            <td>
                                                {{ $year}}
                                            </td>
                                            <td>
                                                {{ $sem}}
                                            </td>
                                            <td nowrap>
                                                @foreach($exam as $item)
                                                
                                                @if($item->dean_status == null)
                                                <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.downloadExamResults',['id' => Crypt::encrypt($item->id), 'sem' => Crypt::encrypt($sem), 'year' => Crypt::encrypt($year)]) }}"> Download </a>

                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.approveExamMarks',['id' => Crypt::encrypt($item->id)]) }}"> Approve  </a>

                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $item->id }}"> Decline </a>

                                                    @elseif($item->dean_status === 1 && $item->registrar_status === null)

                                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.downloadExamResults',['id' => Crypt::encrypt($item->id), 'sem' => Crypt::encrypt($sem), 'year' => Crypt::encrypt($year)]) }}"> Download </a>

                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $item->id }}"> Decline </a>

                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.submitExamMarks',['id' => Crypt::encrypt($item->id)]) }}"> Submit </a>

                                                    @elseif($item->dean_status === 1 && $item->registrar_status === 0 && $item->status === 0 )
                                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.downloadExamResults',['id' => Crypt::encrypt($item->id), 'sem' => Crypt::encrypt($sem), 'year' => Crypt::encrypt($year)]) }}"> Download </a>

                                                    <a class="btn btn-outline-info btn-sm" disabled=""> submitted to registrar </a>

                                                    @elseif($item->dean_status === 2 && $item->registrar_status === null )
                                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.downloadExamResults',['id' => Crypt::encrypt($item->id), 'sem' => Crypt::encrypt($sem), 'year' => Crypt::encrypt($year)]) }}">Download </a>

                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.approveExamMarks',['id' => Crypt::encrypt($item->id)]) }}"> Approve  </a>

                                                    <a class="btn btn-outline-info btn-sm" href="{{route('dean.revertExamMarks',['id' => Crypt::encrypt($item->id)]) }}"> revert to cod </a>

                                                    @elseif($item->processExams->status === 2)
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.downloadExamResults',['id' => Crypt::encrypt($item->id), 'sem' => Crypt::encrypt($sem), 'year' => Crypt::encrypt($year)]) }}">Download </a>
                                                        <a class="btn btn-outline-info btn-sm" disabled=""> reverted to cod </a>
                                                                                                             
                                                @endif
                                                @endforeach
                                                <div class="modal fade" id="staticBackdrop-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('dean.declineExams', ['id' => Crypt::encrypt($item->id)]) }}">
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
    </div>
@endsection
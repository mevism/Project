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
                        ACADEMIC YEAR WORKLOAD
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Workloads
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
                            <thead>
                                <th>#</th>
                                <th>Department</th>
                                <th>Academic Year</th>
                                <th>Academic Semester</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                                @foreach($departments as $workloads)

                                    @foreach($workloads as $workload)

                                        <tr>
                                            <td>  {{ $loop->iteration }}</td>
                                            <td>
                                                {{ $workload->workloadProcessed->first()->workloadDept->dept_code }}
                                            </td>
                                            <td>
                                            {{ $workload->academic_year}}
                                            </td>

                                            <td>
                                                {{ $workload->academic_semester}}
                                            </td>
                                            <td nowrap>
                                                @if($workload->dean_status == null)
                                                    <a class="btn btn-outline-info btn-sm" href="{{route('dean.viewWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> view </a>

                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.approveWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Approve  </a>

                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $workload->id }}"> Decline </a>
                                                @else
                                                    @if($workload->dean_status === 1 && $workload->registrar_status === null )

                                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $workload->id }}"
                                                        > Decline </a>

                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.submitWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Submit </a>
                                                    @elseif($workload->dean_status === 1 && $workload->registrar_status === 0 && $workload->status === 0)
                                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.viewWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> view </a>
                                                    <a class="btn btn-outline-info btn-sm" disabled=""> processing </a>

                                                    @elseif($workload->dean_status === 2 && $workload->registrar_status === null && $workload->workloadProcessed->first()->status === null)
                                                    <a class="btn btn-outline-success btn-sm" href="{{route('dean.approveWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Approve
                                                    </a>

                                                    <a class="btn btn-outline-primary btn-sm" href="{{route('dean.revertWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Revert to COD
                                                    </a>

                                                    @elseif($workload->dean_status === 2 && $workload->workloadProcessed->first()->status === 0)
                                                    <a class="btn btn-outline-primary btn-sm" href=""> Reverted to COD
                                                    </a>
                                                    @elseif($workload->dean_status === 1 && $workload->registrar_status === 2)
                                                    <a class="btn btn-outline-info btn-sm" href="{{route('dean.viewWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Review </a>

                                                    <a class="btn btn-outline-primary btn-sm" href="{{route('dean.revertWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Revert to COD
                                                    </a>

                                                    {{-- @elseif($workload->dean_status === 1 && $workload->registrar_status === 2 &&   $workload->workloadProcessed->first()->status === 0)
                                                    <a class="btn btn-outline-primary btn-sm" href=""> Reverted to COD
                                                    </a> --}}

                                                    @elseif($workload->dean_status === 1 && $workload->registrar_status === 1 && $workload->status === 1)
                                                        @if($workload->workloadProcessed->first()->status === 0)
                                                            <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.viewWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> view </a>

                                                        <a class="btn btn-outline-info btn-sm" href="{{route('dean.workloadPublished',['id' => Crypt::encrypt($workload->id)]) }}"> publish
                                                         </a>
                                                        @else
                                                        <a class="btn btn-outline-success btn-sm" disabled="">  Published </a>
                                                            <a class="btn btn-outline-secondary btn-sm" href="{{route('dean.viewWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> view </a>

                                                            <a class="btn btn-outline-primary btn-sm" href="{{route('dean.printWorkload',['id' => Crypt::encrypt($workload->id)]) }}"> Download </a>

                                                        @endif
                                                    @endif
                                                @endif


                                            <div class="modal fade" id="staticBackdrop-{{ $workload->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('dean.declineWorkload', ['id' => Crypt::encrypt($workload->id)]) }}">
                                                                @csrf
                                                                <div class="d-flex justify-content-center mb-4">
                                                                    <div class="col-md-11">
                                                                        <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                                                        {{-- <input type="hidden" value="{{ $leave->id }}" name="transfer_id"> --}}
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
        <!-- Dynamic Table Responsive -->
    </div>
@endsection

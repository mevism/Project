@extends('cod::layouts.backend')
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
                        {{ $user->title }} {{ $user->last_name.' '.$user->first_name }} QUALIFICATIONS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Qualifications</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Lecturer Qualifications
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-12 table-responsive table-primary">
                    <table id="example" class="table table-borderless table-sm table-striped table-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th> LEVEL OF STUDY </th>
                        <th> INSTITUTION NAME </th>
                        <th> QUALIFICATION </th>
                        <th> status </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($user->Users->lecturerQualification as $key => $qualification)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td>
                                    @if($qualification->level == 1)
                                        CERTIFICATE
                                    @elseif($qualification->level == 2)
                                        DIPLOMA
                                    @elseif($qualification->level == 3)
                                        UNDERGRADUATE
                                    @elseif($qualification->level == 4)
                                        MASTERS
                                    @elseif($qualification->level == 5)
                                        PHD
                                    @else
                                        NON STANDARD
                                    @endif
                                </td>
                                <td> {{ $qualification->institution }} </td>
                                <td> {{ $qualification->qualification }} </td>

                                <td>
                                    @if($qualification->status == 0)
                                        <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending </span>
                                    @elseif($qualification->status == 1)
                                        <span class="badge bg-success"> <i class="fa fa-check"></i> approved </span>
                                    @else
                                        <span class="badge bg-warning"> <i class="fa fa-ban"></i> declined </span>
                                    @endif

                                </td>
                                <td nowrap="">
                                    @if($qualification->status == 0)
                                        <a class="btn btn-sm btn-alt-success" onclick="return confirm('Are you sure you want approve this qualification?')" href="{{ route('department.approveQualification', $qualification->qualification_id) }}">Approve</a>
                                        <a class="btn btn-sm btn-alt-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $qualification->qualification_id }}" >Decline</a>
                                    @elseif($qualification->status == 1)
                                        <a class="btn btn-sm btn-alt-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $qualification->qualification_id }}" >Revoke</a>
                                    @else
                                        <a class="btn btn-sm btn-alt-success" onclick="return confirm('Are you sure you want approve this qualification?')" href="{{ route('department.approveQualification', $qualification->qualification_id) }}">Approve</a>
                                    @endif

                                </td>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop-{{ $qualification->qualification_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reasons for rejecting the qualification</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-md-12">
                                                        <form method="post" action="{{ route('department.rejectQualification', $qualification->qualification_id) }}">
                                                            @csrf
                                                            <div class="mb-4 form-floating">
                                                                <textarea name="reason" class="form-control" placeholder="hello" rows="5" style="min-height: 150px !important;"></textarea>
                                                                <label>Why are you rejecting this qualification</label>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-outline-danger col-md-7">Decline</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

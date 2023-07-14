
@extends('lecturer::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        My Qualifications
                    </h6>
                </div>

                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Qualifications
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
                            <div class="d-flex justify-content-end m-2">
                                <a class="btn btn-sm btn-alt-primary" data-toggle="click-ripple" href="{{ route('lecturer.addqualifications') }}">Add Qualifications </a>
                            </div>

            <table id="example" class="table table-sm table-borderless table-striped table-responsive fs-sm">
                @csrf
                @method('delete')

                    <thead>
                        <th></th>
                        <th>Level</th>
                        <th>Institution</th>
                        <th>Qualification</th>
                        <th>Status</th>
                        <th>Action</th>

                    </thead>
                    <tbody>
                        @foreach($qualifications as $key => $qualification)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @if($qualification->level==1)
                                        CERTIFICATE
                                    @elseif($qualification->level==2)
                                         DIPLOMA
                                    @elseif($qualification->level==3)
                                        BACHELORS
                                    @elseif($qualification->level==4)
                                        MASTERS
                                    @elseif($qualification->level==5)
                                        PHD
                                    @endif
                                </td>
                                <td>{{ $qualification->institution}}</td>
                                <td>{{ $qualification->qualification}}</td>
                                <td nowrap>
                                    @if($qualification->status == 0)
                                    <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending</span>
                                    @elseif($qualification->status==1)
                                    <span class="badge bg-success"> <i class="fa fa-check"></i> Approved</span>
                                    @elseif($qualification->status==2)
                                    <span class="badge bg-danger" > <i class="fa fa-ban" ></i> Declined </span>
                                    <span>
                                    <a class="link m-3" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $qualification->qualification_id }}"> Why? </a>
                                    </span>
                                    @endif
                                </td>
                                <td nowrap="">
                                    @if($qualification->status==0)
                                    <a class="btn btn-sm btn-alt-danger" href="{{ route('lecturer.deleteQualification',  $qualification->qualification_id) }}">Drop</a>
                                    @elseif($qualification->status==1)
                                    <a class="btn btn-sm btn-alt-success" disabled>Verified</a>
                                    @elseif($qualification->status==2)
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('lecturer.editQualifications', $qualification->qualification_id) }}">Edit</a>
                                    <a class="btn btn-sm btn-alt-danger" href="{{ route('lecturer.deleteQualification',$qualification->qualification_id) }}">Drop</a>
                                    @endif
                                </td>
                                <div class="modal fade" id="exampleModal-{{$qualification->qualification_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h6 class="modal-title fs-5" id="exampleModalLabel">Qualification Remarks</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($qualification->getQualificationRemark as $remark )
                                            <p>{{\Carbon\Carbon::parse($remark->created_at)->format('d-M-y')}} - {{$remark->remarks}}</p>
                                            @endforeach

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

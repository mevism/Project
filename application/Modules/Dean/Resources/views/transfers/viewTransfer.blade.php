@extends('dean::layouts.backend')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0">
                    Update Transfer Status
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Transfer</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Status
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-5 mb-1 fs-sm">
                    <div class="row p-1">
                    <div class="col-md-4 fw-bolder text-start">Student Name </div>
                    <div class="col-md-8"> {{ $data->student_id }} </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-md-4 fw-bolder text-start">Department</div>
                        <div class="col-md-8"> {{ $data->department_id }} </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-md-4 fw-bolder text-start">Course Name</div>
                        <div class="col-md-8"> {{ $data->course_id }} </div>
                    </div>
                    
                    <div class="row py-3">
                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-borderless">
                                <th>Course Details</th>
                                <th>Course Transfer Reqiurements</th>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-md-4 fw-bolder text-start">Dean Status</div>
                        <div class="col-md-8">

                            @if($data->dean_status == 1)
                                <span class="badge bg-success">Accepted by Dean</span>
                            @elseif($data->dean_status == 2)
                                <span class="badge bg-danger">Rejected by Dean</span>
                            @elseif($data->dean_status == 3)
                                <span class="badge bg-primary">Awaiting COD review</span>
                            @else
                                <span class="badge bg-info">Awaiting Dean review</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center py-1">

                    @if($data->dean_status == 3)
                        <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('dean.acceptTransfer', [ 'id' => Crypt::encrypt($data->id)]) }}">Agree</a>
                        <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Disagree</a>
                        <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.transfer') }}">Close</a>
                    @elseif($data->dean_status == 4)
                            <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('dean.acceptTransfer',[ 'id' => Crypt::encrypt($data->id)]) }}">Agree</a>
                            <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Disagree</a>
                            <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.transfer') }}">Close</a>
                        @elseif($data->dean_status == 0)
                        <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('dean.acceptTransfer', [ 'id' => Crypt::encrypt($data->id)]) }}">Agree</a>
                        <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Disagree</a>
                        <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.transfer') }}">Close</a>
                    @elseif($data->dean_status == 1)
                        <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Disagree</a>
                        <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.transfer') }}">Close</a>
                    @else
                        <a class="btn btn-sm btn-alt-success m-2" data-toggle="click-ripple" href="{{ route('dean.acceptTransfer', [ 'id' => Crypt::encrypt($data->id)]) }}">Agree</a>
                        <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.transfer') }}">Close</a>
                    @endif
                </div>
                </div>
            </div>
        
            <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popin" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Reason(s) </h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('dean.rejectTransfer', [ 'id' => Crypt::encrypt($data->id)]) }}" method="post">
                                    @csrf
                                    <div class="d-flex justify-content-center m-3">
                                    <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required rows="6"></textarea>
                                    <input type="hidden" name="{{ $data->id }}">
                                    </div>
                                    <div class="d-flex justify-content-center mb-2">
                                    <button type="submit" class="btn btn-alt-danger btn-sm">Disagree</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full text-end bg-body">
                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        
        @endsection
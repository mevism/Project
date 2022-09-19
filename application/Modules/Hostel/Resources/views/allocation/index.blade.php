@extends('hostel::layouts.backend')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Accommodation
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Hostel</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Allocation
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
                    <table id="example" class="table table-responsive table-md table-striped table-bordered table-vcenter fs-sm">
                            <thead>
                            <th>Reg. Number</th>
                            <th>Applicant Name</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th>Phone Number</th>
                            <th>Student Email</th>
                            <th>Disabled</th>
                            <th>Status</th>
                            <th style="white-space: nowrap !important;">Action</th>
                            </thead>
                            <tbody>
                            @foreach($student as $row)
                                <tr>
                                    <td>{{ $row->reg_number }}</td>
                                    <td> {{ $row->sname }} {{ $row->fname }} {{ $row->mname }} </td>
                                    <td> {{ $row->gender }}</td>
                                    <td> {{ $row->marital_status }}</td>
                                    <td> {{ $row->mobile }}</td>
                                    <td> {{ $row->student_email }}</td>
                                    <td> {{ $row->disabled }}</td>
                                    <td>
{{--                                        @if($row->registrar_status == 0)--}}
                                            <span class="badge bg-info"> <i class="fa fa-spinner"></i> pending</span>
{{--                                        @elseif($row->registrar_status == 1)--}}
{{--                                            <span class="badge bg-success"> <i class="fa fa-check"></i> enrolled</span>--}}
{{--                                        @else--}}
{{--                                            <span class="badge bg-danger"> <i class="fa fa-close"></i> rejected</span>--}}
{{--                                        @endif--}}
                                    </td>
                                    <td nowrap="">
{{--                                        @if($row->registrar_status == 0)--}}
{{--                                            <a class="btn btn-sm btn-alt-success" data-toggle="click-ripple" onclick="return confirm('Are you sure you want to erroll this student?')" href="{{ route('courses.admitStudent', $row->id) }}"> Enroll </a>--}}
{{--                                            <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> Reject </a>--}}
{{--                                            <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin{{ $row->id }}" aria-hidden="true">--}}
{{--                                                <div class="modal-dialog modal-dialog-popin" role="document">--}}
{{--                                                    <div class="modal-content">--}}
{{--                                                        <div class="block block-rounded block-transparent mb-0">--}}
{{--                                                            <div class="block-header block-header-default">--}}
{{--                                                                <h3 class="block-title">Reason(s) </h3>--}}
{{--                                                                <div class="block-options">--}}
{{--                                                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                                                                        <i class="fa fa-fw fa-times"></i>--}}
{{--                                                                    </button>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="block-content fs-sm">--}}
{{--                                                                <form action="{{ route('medical.rejectAdmission', $app->id) }}" method="post">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <div class="row col-md-12 mb-3">--}}
{{--                                                                        <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required></textarea>--}}
{{--                                                                        <input type="hidden" name="{{ $row->id }}">--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="d-flex justify-content-center mb-2">--}}
{{--                                                                        <button type="submit" class="btn btn-alt-danger btn-sm">Reject</button>--}}
{{--                                                                    </div>--}}
{{--                                                                </form>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="block-content block-content-full text-end bg-body">--}}
{{--                                                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>--}}
{{--                                                                --}}{{--                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Okay</button>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @elseif($row->registrar_status == 1)--}}
{{--                                            <a class="btn btn-sm btn-alt-info" href="{{ route('cod.reviewAdmission', $row->id) }}"> Edit </a>--}}
{{--                                        @else--}}
{{--                                            <a class="btn btn-sm btn-alt-info" href="{{ route('cod.reviewAdmission', $row->id) }}"> Edit </a>--}}
{{--                                        @endif--}}
                                        <a class="btn btn-sm btn-alt-primary" data-toggle="click-ripple" href="#">Allocate</a>
                                        <a class="btn btn-sm btn-alt-warning" data-toggle="click-ripple" href="#">Vacate</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

</script>
@endsection

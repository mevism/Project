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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        READMISSION REQUESTS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="#">Readmissions</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Readmissions
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th>Reg. NUMBER</th>
                    <th>NAME</th>
                    <th>LEAVE TYPE</th>
                    <th>CURRENT STAGE</th>
                    <th>PERIOD</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($readmissions as $readmission)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ $readmission->leaves->studentLeave->reg_number }} </td>
                                <td> {{ $readmission->leaves->studentLeave->sname.' '.$readmission->leaves->studentLeave->fname.' '.$readmission->leaves->studentLeave->mname }} </td>
                                <td> @if($readmission->leaves->type == 1)
                                        ACADEMIC LEAVE
                                    @elseif($readmission->leaves->type == 2)
                                        DEFERMENT
                                    @elseif($readmission->leaves->type == 3)
                                        SUSPENSION
                                    @else
                                        DISCONTINUATION
                                    @endif </td>
                                <td>
                                    Year : {{ $readmission->leaves->year_study }} Semester : {{ $readmission->leaves->semester_study }}
                                </td>
                                <td>
                                    From : {{ $readmission->leaves->from }} <br>
                                    To : {{ $readmission->leaves->to }} <br>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline-dark" href="{{ route('dean.selectedReadmission', ['id' => Crypt::encrypt($readmission->id)]) }}"> View </a>

                                    @if($readmission->readmissionApproval != null)
                                        @if($readmission->readmissionApproval->dean_status == 1)
                                            <i class="fa fa-check text-success"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

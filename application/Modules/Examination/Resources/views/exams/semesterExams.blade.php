@extends('examination::layouts.backend')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 0
            }
        } );
    } );
</script>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        {{ strtoupper($semester) }} {{ $year }} EXAMS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Exams</a>
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
                    <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <thead>
                        <th> # </th>
                        <th> UNIT code </th>
                        <th> UNIT Name</th>
                        <th> Students </th>
                        <th> Marks Entered </th>
                        <th> Action </th>
                        </thead>
                        <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($exams as $class => $exam)
                            <tr style="background: lightgrey !important; ">
                                <td colspan="6" class="fw-bold fs-8"> {{ $class }} </td>
                            </tr>
                            @foreach($exam->groupBy('unit_code') as $code => $unit)
                                <tr>
                                    <td> {{ ++$i }} </td>
                                    <td> {{ $code }} </td>
                                    <td> {{ $unit->first()->unit->unit_name }} </td>
                                    <td> {{ count($unit->all()) }} </td>
                                    <td> {{ count($unit->where('exam', '!=', 'ABSENT')) }} </td>
                                    <td>
                                        @if(!$unit->where('status', 1)->first())
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="btn-group">
                                                        <form class="m-0 p-0" method="post" action="{{ route('examination.previewExam') }}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $class }}" name="class">
                                                            <input type="hidden" value="{{ $code }}" name="unit">
                                                            <button type="submit" class="btn btn-sm btn-outline-dark">View</button>
                                                        </form>
                                                        <span>&nbsp;</span>
                                                        <form class="m-0 p-0" method="post" action="{{ route('examination.receiveExam') }}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $class }}" name="class">
                                                            <input type="hidden" value="{{ $code }}" name="unit">
                                                            <button type="submit" onclick="return confirm('Are you sure you want to receive this exam?')" class="btn btn-sm btn-outline-success">Receive</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($unit->first()->exam_approval_id == null)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="btn-group">
                                                        <form class="m-0 p-0" method="post" action="{{ route('examination.processExam') }}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $class }}" name="class">
                                                            <input type="hidden" value="{{ $code }}" name="unit">
                                                            <button type="submit" class="btn btn-sm btn-outline-dark">Process Marks</button>
                                                        </form>
                                                        <span>&nbsp;</span>
                                                        <form class="m-0 p-0" method="post" action="{{ route('examination.submitMarks') }}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $class }}" name="class">
                                                            <input type="hidden" value="{{ $code }}" name="unit">
                                                            <button type="submit" formmethod="post" onclick="return confirm('Are you sure you want to submit this exam to COD?')" class="btn btn-sm btn-outline-success">Submit to COD </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($unit->first()->exam_approval_id !== null)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="btn-group">
                                                        <form class="m-0 p-0" method="post" action="{{ route('examination.previewExam') }}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $class }}" name="class">
                                                            <input type="hidden" value="{{ $code }}" name="unit">
                                                            <button type="submit" class="btn btn-sm btn-outline-dark">View</button>
                                                        </form>
                                                        <span>&nbsp;</span>
                                                    <a class="btn btn-sm btn-primary disabled"> Awaiting processing</a> </div>
                                                </div>
                                            </div>
                                    </td>
                                    @endif
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
    <!-- END Page Content -->
@endsection



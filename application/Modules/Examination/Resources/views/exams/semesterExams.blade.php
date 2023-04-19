@extends('examination::layouts.backend')

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
                    <h5 class="h5 fw-bold mb-0">
                        Exams
                    </h5>
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
                    <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th> # </th>
                        <th> Academic Year </th>
                        <th> UNIT code </th>
                        <th> UNIT Name</th>
                        <th> Students </th>
                        <th> Scripts </th>
                        <th> Action </th>
                        </thead>
                        <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($exams as $class => $exam)
                            <tr>
                                <td> {{ ++$i }} </td>
                                <td> {{ $class }} </td>
                                <td>
                                    @foreach($exam->groupBy('unit_code') as $code => $unit)
                                        <p>{{ $code }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($exam->groupBy('unit_code') as $code => $unit)
                                        <p>{{ $unit->first()->unit->unit_name }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($exam->groupBy('unit_code') as $code => $unit)
                                        <p>{{ count($unit->all()) }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($exam->groupBy('unit_code') as $code => $unit)
                                        <p>{{ count($unit->where('exam', '!=', 'ABSENT')) }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($exam->groupBy('unit_code') as $code => $unit)
                                        <p>
                                           @if(!$unit->where('status', 1)->first())
                                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('examination.previewExam', ['class' => Crypt::encrypt($class), 'code' => Crypt::encrypt($code)]) }}"> View </a>
                                                <a class="btn btn-sm btn-outline-primary" onclick="return confirm('Are you sure you want to receive this exam?')" href="{{ route('examination.receiveExam', ['class' => Crypt::encrypt($class), 'code' => Crypt::encrypt($code)]) }}"> Receive </a>
                                            @else
                                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('examination.previewExam', ['class' => Crypt::encrypt($class), 'code' => Crypt::encrypt($code)]) }}"> Process </a>
                                                <a class="btn btn-sm btn-outline-primary" onclick="return confirm('Are you sure you want to receive this exam?')" href="{{ route('examination.receiveExam', ['class' => Crypt::encrypt($class), 'code' => Crypt::encrypt($code)]) }}"> Submit to COD </a>
                                            @endif
                                        </p>
                                    @endforeach
                                </td>
                            </tr>
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



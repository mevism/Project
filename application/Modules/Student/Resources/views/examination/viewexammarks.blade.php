@extends('student::layouts.backend')
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
                <h6 class="h6 fw-bold mb-0">
                    {{ $stage }} EXAM RESULTS
                </h6>
            </div>
            <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('student.examresults')}}"> STUDENT </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        SEMESTER RESULTS
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <table id="example"  class="table table-striped table-bordered fs-sm">
                <thead>
                <th>#</th>
                <th> Unit code </th>
                <th> Unit Name </th>
                <th> Grade </th>
                <th> TYpe </th>
                </thead>
                @php
                $i = 0;
               @endphp
            @foreach($results as $mark)
            <tr>
                <td> {{ ++$i }} </td>
                <td>{{$mark->unit_code}}</td>
                <td>{{$mark->ModeratedUnits->unit_name}}</td>
                <td>
                    @if($mark->total_exam == 'ABSENT')
                        ABSENT
                    @else
                        @if($mark->total_exam + $mark->total_cat >= 70)
                            A
                        @elseif($mark->total_exam + $mark->total_cat >= 60)
                            B
                        @elseif($mark->total_exam + $mark->total_cat >= 50)
                            C
                        @elseif($mark->total_exam + $mark->total_cat >= 40)
                            D
                        @else
                            E
                        @endif
                    @endif
                </td>
                <td>
                    @php
                        $thirdNumber = '';
                        $attempts = explode('.', $mark->attempt);

                        if (count($attempts) >= 3) {
                            $firstNumber = $attempts[0];
                            $secondNumber = $attempts[1];
                            $thirdNumber = $attempts[2];
                        } elseif (count($attempts) === 2) {
                            $firstNumber = $attempts[0];
                            $secondNumber = $attempts[1];
                        } else {
                            $firstNumber = $mark->attempt;
                            $secondNumber = ''; // Set secondNumber to an empty string if it's not present
                        }
                    @endphp

                    @if($firstNumber >= 1 && $firstNumber <= 7 && $thirdNumber === '')
                        ORDINARY EXAM
                    @elseif($firstNumber >= 1 && $firstNumber <= 7 && $thirdNumber == 1)
                        SPECIAL EXAM
                    @elseif($firstNumber >= 1 && $firstNumber <= 7 && $thirdNumber == 2)
                        SUPPLEMENTARY EXAM
                    @elseif($firstNumber >= 1 && $firstNumber <= 7 && $thirdNumber == 3)
                        RETAKE EXAM
                    @endif
                </td>
            </tr>
            @endforeach

            </table>
        </div></div>
    </div>



@endsection

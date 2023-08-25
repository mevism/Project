@extends('cod::layouts.backend')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script

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
                    <h6 class="h6 fw-bold mb-0">
                        EXAMINATION
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Departmental</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Examinations
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
                        <tbody>
                        @foreach($results as $class => $examResults)
                            <tr style="background: lightgrey !important; ">
                                <td colspan="{{ 5 + count($examResults) }}" class="fw-bold"> {{ $class }} </td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center fw-bold fs-6">STUDENT INFORMATION </th>
                                <th colspan="{{ 1 + count($examResults) }}" class="text-center fw-bold fs-6">SEMESTER UNITS AND MARKS </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>STUDENT NUMBER</th>
                                <th>STUDENT NAME</th>
                                <th>GENDER</th>
                                @foreach($examResults as $unitCode => $studentUnits)
                                <th> {{ $unitCode }} </th>
                                @endforeach
                                <th>REMARKS</th>
                            </tr>
                            @foreach ($studentUnits as $student_number => $unitResults)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student_number }}</td>
                                    <td>
                                        @foreach ($unitResults as $student)
                                            {{ $student->studentModeratedResults->sname.' '.$student->studentModeratedResults->fname.' '.$student->studentModeratedResults->mname }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($unitResults as $student)
                                            {{ $student->studentModeratedResults->gender }}
                                        @endforeach
                                    </td>
                                    @foreach ($examResults as $unitCode => $studentUnitsData)
                                        <td>
                                            @foreach ($studentUnitsData as $students)
                                                @foreach($students as $student)
                                                    @if ($student->student_number == $student_number && $student->unit_code == $unitCode)
                                                        @if($student->total_exam == 'ABSENT')
                                                            {{ $student->total_cat  }}<sup>*</sup>
                                                        @else
                                                            {{ $student->total_cat + $student->total_exam }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>
                                    @endforeach
                                    @php
                                        $studentRemarks = [];
                                    @endphp

                                    @foreach ($examResults as $unitCode => $studentUnitsData)
                                        @foreach ($studentUnitsData as $students)
                                            @foreach ($students as $student)
                                                @if ($student->student_number == $student_number && $student->unit_code == $unitCode)
                                                    @if ($student->total_exam == 'ABSENT')
                                                        @php
                                                            $studentRemarks[] = 'ABS';
                                                        @endphp
                                                    @elseif ($student->total_cat + $student->total_exam < 40)
                                                        @php
                                                            $studentRemarks[] = 'FAIL';
                                                        @endphp
                                                    @else
                                                        @php
                                                            $studentRemarks[] = 'PASS';
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach

                                    @php
                                        $remarkCounts = array_count_values($studentRemarks);
                                        $absCount = $remarkCounts['ABS'] ?? 0;
                                        $failCount = $remarkCounts['FAIL'] ?? 0;
                                        $passCount = $remarkCounts['PASS'] ?? 0;
                                    @endphp

                                    <td>
                                        @if($failCount == 0 && $absCount == 0)
                                            PASS
                                        @elseif($failCount > 0 && $absCount > 0 )
                                            {{ $absCount }} ABS, {{ $failCount }} FAIL
                                        @elseif($absCount > 0 )
                                            {{ $absCount }} ABS
                                        @elseif($failCount > 0 )
                                            {{ $failCount }} FAIL
                                        @endif
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

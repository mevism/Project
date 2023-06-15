@extends('registrar::layouts.backend')
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
                        LIST OF STUDENTS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">schools</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Exam marks
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
                       <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped fs-sm">
                            <thead>
                                <th style=" visibility: hidden">#</th>
                                <th style=" visibility: hidden">REG NO</th>
                                <th style=" visibility: hidden">student name</th>
                                <th style=" visibility: hidden">sex</th>
                                <th>sem units and marks</th>
                                <th style=" visibility: hidden">T.units</th>
                                <th style=" visibility: hidden">t.mean</th>
                                <th style=" visibility: hidden">mean</th>
                                <th style=" visibility: hidden">remarks</th>
                            </thead>
                            <thead>
                                <th>#</th>
                                <th>REG NO</th>
                                <th>student name</th>
                                <th>sex</th>
                                <th nowrap="" >
                                    <div >
                                      @php $output = array(); @endphp
                                        @foreach($studentDetails as $unit)
                                            @if (!empty($regs[$unit->reg_number]))
                                                @foreach ($regs[$unit->reg_number] as $reg)
                                                    @if (!in_array($reg->unit_code, $output))
                                                    <div class="record" style="border-right: 1px solid black;padding-right: 10px;margin-right: 10px;display: inline-block;height: 40px;">
                                                        {{ substr($reg->unit_code, 0, -4) }} <br>
                                                        {{ substr($reg->unit_code, -4) }}
                                                        </div>
                                                        @php array_push($output, $reg->unit_code); @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </th>
                                <th>T.units</th>
                                <th>t.marks</th>
                                <th>mean</th>
                                <th>remarks</th>
                            </thead>
                            <tbody>
                                @foreach($studentDetails as   $student)                     
                                        <tr>
                                            <td>  {{ $loop->iteration }}</td>                                        
                                            <td> {{ $student->reg_number}} </td>
                                            <td> {{ $student->sname . ' ' . $student->fname . ' ' . $student->mname}}</td>
                                            <td> {{ $student->gender}} </td>
                                            <td nowrap="">
                                                <div>
                                                    @if (!empty($regs[$student->reg_number]))
                                                        @foreach ($regs[$student->reg_number] as $reg)
                                                        <div class="record" style="border-right: 1px solid black;padding-right: 10px;margin-right: 10px;display: inline-block;height: 40px;">
                                                            {{ $reg->cat }}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td nowrap>    
                                                @php $output = array(); @endphp                                                 
                                                @foreach($studentDetails as $unit)
                                                    @if (!empty($regs[$unit->reg_number]))
                                                        @foreach ($regs[$unit->reg_number] as $reg)
                                                            @if (!in_array($reg->unit_code, $output))
                                                                <div class="record" style="border-right: 1px solid black;padding-right: 10px;margin-right: 10px;display: inline-block;height: 40px; display:none">
                                                                    {{ substr($reg->unit_code, 0, -4) }} <br>
                                                                    {{ substr($reg->unit_code, -4) }}
                                                                </div>
                                                                @php array_push($output, $reg->unit_code); @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach                                                
                                                @php
                                                    $unique_unit_codes_count = count($output);
                                                    echo $unique_unit_codes_count;
                                                @endphp                                                
                                            </td>
                                            <td>
                                                @php $student_total_marks = 0; @endphp
                                                @if (!empty($regs[$student->reg_number]))
                                                    @foreach ($regs[$student->reg_number] as $reg)
                                                        <div class="record" style="border-right: 1px solid black;padding-right: 10px;margin-right: 10px;display: inline-block;height: 40px; display:none">
                                                            {{ $reg->cat }}
                                                        </div>
                                                        @php $student_total_marks += $reg->cat; @endphp
                                                    @endforeach
                                                @endif
                                                <div class="total-marks" style="display: inline-block;">
                                                    {{ $student_total_marks }}
                                                </div>                                            
                                            </td>
                                            <td>
                                                @php $student_sum = 0;  $student_count = 0; @endphp
                                                @if (!empty($regs[$student->reg_number]))
                                                    @foreach ($regs[$student->reg_number] as $reg)
                                                        <div class="record" style="border-right: 1px solid black;padding-right: 10px;margin-right: 10px;display: inline-block;height: 40px; display:none">
                                                            {{ $reg->cat }}
                                                        </div>
                                                        @php $student_sum += $reg->cat;  $student_count++; @endphp
                                                    @endforeach
                                                @endif
                                                @if ($student_count > 0)
                                                    <div class="mean" style="display: inline-block;">
                                                        {{ round($student_sum / $student_count, 1) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                @endforeach
                               
                            </tbody>
                            </table> 
                        
                       </div>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
@endsection

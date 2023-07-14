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
                        SEMESTER WORKLOADS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Workload</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Workload
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
                    <div class="">
                            <table id="example" class="table table-borderless table-sm table-striped fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Class code </th>
                        <th>UNIT code </th>
                        <th>UNIT name</th>
                        <th>Stage</th>
                        <th>Unit Lecturer(s)</th>
                        </thead>
                        {{-- @if ($staff->placedUser->first()->employment_terms == 'FT' && $staff->hasRole('Dean/Director') || $staff->hasRole('Chairperson of Department') || $staff->hasRole('Exam Coordinator')) --}}
                        <tbody>
                        @foreach ($units as $key => $unit)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $class->class_code }} </td>
                                <td> {{ $unit->unit_code }} </td>
                                <td> {{ $unit->SyllabusUnit->unit_name }} </td>
                                <td> {{ $unit->stage.'.'.$unit->semester }} </td>
                                <td nowrap="">
                                    @php $unitLec = $unit->SyllabusUnit->UnitsLectures()->where('status', 1)->get(); @endphp
                                    @if(count($unitLec) < 1)
                                        No Unit Lecturer
                                    @else
                                        @if($workloads->where('unit_id', $unit->SyllabusUnit->unit_id)->where('class_code', $class->class_code)->first())
                                            @foreach($lecturers as $lecturer)
                                                @if($workloads->where('unit_id', $unit->SyllabusUnit->unit_id)->where('class_code', $class->class_code)->first()->user_id == $lecturer->user_id)
                                                    <div class="row mb-1">
                                                        <div class="col col-md-6">
                                                            {{ $lecturer->staffInfos->title }} {{ $lecturer->staffInfos->last_name}} {{ $lecturer->staffInfos->first_name}} {{ $lecturer->staffInfos->middle_name}} ({{ $lecturer->employments->first()->employment_terms }})
                                                        </div>
                                                        <div class="col col-md-3">

                                                            @php $loadcount = $workloads->where('user_id', $lecturer->user_id)->where('academic_year', $class->academic_year)->where('period', $class->academic_semester)->count();
                                                            @endphp
                                                            @php
                                                            if($lecturer->employments->first()->employment_terms == 'FT'){
                                                                $maxLoad  =  '7';
                                                            }else{
                                                                $maxLoad  =  '4';
                                                            }
                                                            @endphp
                                                            <?php $percent = ($loadcount/$maxLoad)*100 ?>
                                                            {{ $loadcount }}/ {{ $maxLoad }} -
                                                                @if(number_format($percent, 1) <= 50)
                                                                    <span class="fw-bold text-success">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                            @elseif(number_format($percent, 1) <= 75)
                                                                    <span class="fw-bold text-warning">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                            @else
                                                                <span class="fw-bold text-danger">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                            @endif
                                                        </div>
                                                        <div class="col col-md-3">
{{--                                                            {{ $workload }}--}}
                                                            @if( $workloads->where('unit_id', $unit->SyllabusUnit->unit_id)->where('class_code', $class->class_code)->first()->workload_approval_id == null)
                                                                <a class="btn btn-sm btn-outline-danger ml-2" onclick="return confirm('Are you sure you want to remove allocation')" href="{{ route('department.deleteWorkload', $workloads->where('unit_id', $unit->SyllabusUnit->unit_id)->where('class_code', $class->class_code)->first()->workload_id) }}">Revoke </a>
                                                            @else
                                                                <span class="text-success">Submitted</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($unit->SyllabusUnit->UnitsLectures()->where('status', 1)->get() as $key => $lecturer)
                                                <div class="row mb-0 mt-0 p-0">
                                                    <div class="col col-md-6">
                                                        {{ ++$key }}.
                                                        {{ $lecturer->staffInfos->title }}
                                                        {{ $lecturer->staffInfos->last_name}} {{ $lecturer->staffInfos->first_name}} {{ $lecturer->staffInfos->middle_name}}
                                                        ({{ $lecturer->employments->first()->employment_terms }})

                                                    </div>
                                                    <div class="col col-md-3 mt-0 mb-0">
                                                        @php $loadcount = $workloads->where('user_id', $lecturer->user_id)->where('academic_year', $class->academic_year)->where('period', $class->academic_semester)->count();
                                                        @endphp
                                                        @php
                                                            if($lecturer->employments->first()->employment_terms == 'FT'){
                                                                 $maxLoad  =  '7';
                                                            }else{
                                                                 $maxLoad  =  '4';
                                                            }
                                                        @endphp
                                                        <?php $percent = ($loadcount/$maxLoad)*100 ?>
                                                        {{ $loadcount }}/ {{ $maxLoad }} -
                                                        @if(number_format($percent, 1) <= 50)
                                                            <span class="fw-bold text-success">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                        @elseif(number_format($percent, 1) <= 75)
                                                            <span class="fw-bold text-warning">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                        @else
                                                            <span class="fw-bold text-danger">
                                                                        {{ number_format($percent, 1) }}%
                                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="col col-md-3 mt-0 mb-0">
                                                        <form method="post" action="{{ route('department.allocateUnit') }}">
                                                            @csrf
                                                            <input type="hidden" name="staffId" value="{{ $lecturer->user_id }}">
                                                            <input type="hidden" name="unitId" value="{{ $unit->SyllabusUnit->unit_id }}">
                                                            <input type="hidden" name="patternId" value="{{ $class->class_pattern_id }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-success ml-2"> Allocate </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
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
        </div>
    </div>

@endsection

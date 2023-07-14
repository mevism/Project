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
                    <h5 class="h6 fw-bold mb-0">
                        {{ $semester }}-{{ $year }} WORKLOAD
                    </h5>
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
                <div class="col-12 table-responsive">
                    <table id="example" class="table table-bordered sm table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Staff number </th>
                        <th>Staff name </th>
                        <th>Qualifications </th>
                        <th>Role </th>
                        <th>Class Code</th>
                        <th>Load </th>
                        <th>Std</th>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Level</th>
                        </thead>
                        <tbody>
                        @foreach ($workloads as $lec => $workload)

                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td>
                                    @foreach($lecturers as $lecturer)
                                        @if($lecturer->user_id == $lec)
                                            {{ $lecturer->StaffInfos->staff_number }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($lecturers as $lecturer)
                                        @if($lecturer->user_id == $lec)
                                           {{ $lecturer->StaffInfos->title }}. {{ $lecturer->StaffInfos->last_name }} {{ $lecturer->StaffInfos->first_name }} {{ $lecturer->StaffInfos->middle_name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($lecturers as $lecturer)
                                        @if($lecturer->user_id == $lec)
                                            @foreach( $lecturer->lecturerQualfs()->where('status', 1)->get() as $qualification)
                                                <p>{{ $qualification->qualification }}</p>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($lecturers as $lecturer)
                                        @if($lecturer->user_id == $lec)
                                            @foreach($lecturer->roles as $role)
                                                <p>{{ $role->name }}</p>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td nowrap="">
                                    @foreach($workload as $class)
                                        <p>{{ $class->class_code }}</p>
                                    @endforeach
                                </td>

                                <td>
                                    @php  $userLoad = $workload->count();  @endphp
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->user_id === $lec)
                                            @php $staff = $lecturer; @endphp

                                            @if ($staff->employments->first()->employment_terms == 'FT' && $staff->hasRole(['Chairperson of Department', 'Exam Coordinator', 'Director/Dean']) )
                                            @for ($i = 0; $i < $userLoad; ++$i)
                                                @if ($i < 2)
                                                    @php $load = 'FT'; @endphp
                                                    <p>{{ $load }}</p>
                                                @else
                                                    @php $load = 'PT'; @endphp
                                                    <p>{{ $load }}</p>
                                                @endif
                                            @endfor
                                        @elseif ($staff->employments->first()->employment_terms == 'FT')
                                            @for ($i = 0; $i < $userLoad; ++$i)
                                                @if ($i < 3)
                                                    @php $load = 'FT'; @endphp
                                                    <p>{{ $load }}</p>
                                                @else
                                                    @php $load = 'PT'; @endphp
                                                    <p>{{ $load }}</p>
                                                @endif
                                            @endfor
                                        @else
                                            @for ($i = 0; $i < $userLoad; ++$i)
                                                @if ($i < $userLoad)
                                                    @php $load = 'PT'; @endphp
                                                    <p>{{ $load }}</p>
                                                @endif
                                            @endfor
                                        @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($workload as $class)
                                        <p>{{ $class->classWorkload->studentClass->count() }}</p>
                                    @endforeach
                                </td>
                                <td nowrap="">
                                    @foreach($workload as $class)
                                        <p>{{ $class->workloadUnit->unit_code }}</p>
                                    @endforeach
                                </td>
                                <td nowrap="">
                                    @foreach($workload as $class)
                                        <p>{{ $class->workloadUnit->unit_name }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($workload as $class)
                                        <p>{{ $class->classWorkload->classCourse->level }}</p>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

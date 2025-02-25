@extends('registrar::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        DEPARTMENTAL   WORKLOAD
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Schools</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            workloads
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
                    <table id="example" class="table table-bordered table-striped fs-sm">
                        <thead>
                        <th>#</th>
                        <th>staff number</th>
                        <th>staff name</th>
                        <th>qualification</th>
                        <th>role</th>
                        <th>class code</th>
                        <th>load</th>
                        <th>stds</th>
                        <th>unit code</th>
                        <th>unit name</th>
                        <th>level</th>
                        </thead>
                        <tbody>
                        @foreach($workloads as $department => $deptWorkloads)
                            <tr style="background: gainsboro !important;">
                                <td colspan="2" class="fw-bold"> {{ \Modules\Registrar\Entities\Department::where('department_id', $department)->first()->dept_code }} </td>
                                <td colspan="9" class="fw-bold">{{ \Modules\Registrar\Entities\Department::where('department_id', $department)->first()->name }}</td>
                            </tr>
                            @foreach($deptWorkloads as $userId => $workload)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->user_id  ==  $userId)
                                                {{ $user->StaffInfos->staff_number }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->user_id  ==  $userId)
                                                {{ $user->StaffInfos->title }} {{ $user->StaffInfos->last_name }}  {{ $user->StaffInfos->first_name }} {{ $user->StaffInfos->middle_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->user_id == $userId)
                                                @foreach( $user->lecturerQualfs()->where('status', 1)->get() as $qualification)
                                                    <p>{{ $qualification->qualification }}</p>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->user_id == $userId)
                                                @foreach($user->roles as $role)
                                                    <p>{{ $role->name }}</p>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </td>
                                    <td nowrap="">
                                        @foreach($workload as $class)
                                            <p>{{ $class->WorkloadApprovalView->class_code }}</p>
                                        @endforeach
                                    </td>

                                    <td>
                                        @php  $userLoad = $workload->count();  @endphp
                                        @foreach ($users as $user)
                                            @if ($user->user_id === $userId)
                                                @php $staff = $user; @endphp

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
                                            <p>{{ $class->WorkloadApprovalView->classWorkload->studentClass->count() }}</p>
                                        @endforeach
                                    </td>
                                    <td nowrap="">
                                        @foreach($workload as $class)
                                            <p>{{ $class->WorkloadApprovalView->workloadUnit->unit_code }}</p>
                                        @endforeach
                                    </td>
                                    <td nowrap="">
                                        @foreach($workload as $class)
                                            <p>{{ $class->WorkloadApprovalView->workloadUnit->unit_name }}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($workload as $class)
                                            <p>{{ $class->WorkloadApprovalView->classWorkload->classCourse->level_id }}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css" type="text/css">

    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                rowGroup: {
                    dataSrc: 1 // Adjust the column index for department grouping
                }
            });
        });
    </script>

@endsection

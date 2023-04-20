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
                        SEMESTER WORKLOADS
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
                <div class="col-12">
                    <div class="table-responsive">
                            <table id="example" class="table table-bordered table-responsive-sm table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Class code </th>
                        <th>UNIT NAME </th>
                        <th>UNIT CODE</th>
                        <th>Stage</th>
                        <th>Unit Lecturer(s)</th>
                        <th>No:</th>
                        </thead>  
                        {{-- @if ($staff->placedUser->first()->employment_terms == 'FT' && $staff->hasRole('Dean/Director') || $staff->hasRole('Chairperson of Department') || $staff->hasRole('Exam Coordinator')) --}}
                        <tbody>
                        @foreach ($units as $key => $unit)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $unit->class_code }} </td>
                                <td> {{ $unit->unit_code}} </td>
                                <td> {{ $unit->unit_name }} </td>
                                <td> {{ $unit->stage.'.'.$unit->semester }} </td>
                                <td nowrap="">
                                    {{-- {{ $unit}} --}}
                                    @if($unit->allocateUnit == null)
                                        @php $loaded = $unit->unitTeacher()->where('status', 1)->get(); @endphp
                                        @if(count($loaded) < 1)
                                              No Unit Lecturer
                                        @else
                                            @foreach($unit->unitTeacher()->where('status', 1)->get() as $key => $lecturer)
                                                <div class="row mb-1">
                                                    <div class="col col-md-8">
                                                        {{ ++$key }}. {{ $lecturer->userTeachingArea->title}} {{ $lecturer->userTeachingArea->last_name}} {{ $lecturer->userTeachingArea->first_name}} {{ $lecturer->userTeachingArea->middle_name}} 
                                                        ({{ $lecturer->userTeachingArea->placedUser->first()->employment_terms }})
                                                     
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <a class="btn btn-sm btn-outline-success ml-2" href="{{ route('department.allocateUnit', ['staff_id' =>  Crypt::encrypt($lecturer->userTeachingArea->id), 'unit_id' => Crypt::encrypt($unit->id)]) }}">Allocate </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="row mb-1">
                                            <div class="col col-md-8">
                                                 {{ $unit->allocateUnit->userAllocation->last_name }} {{ $unit->allocateUnit->userAllocation->first_name }} {{ $unit->allocateUnit->userAllocation->middle_name }}
                                                ( {{ $unit->allocateUnit->userAllocation->placedUser->first()->employment_terms }} ) 
                                            </div>
                                            <div class="col col-md-4">
                                                @if($unit->allocateUnit->workload_approval_id === 0 || $unit->allocateUnit->status == 2)
                                                <a class="btn btn-sm btn-outline-danger ml-2" href="{{ route('department.deleteWorkload', ['id' => Crypt::encrypt($unit->allocateUnit->unit_id)]) }}">Revoke </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                       {{-- {{ $unit}} --}}
                                       @if($unit->allocateUnit == null)
                                       @php $loaded = $unit->unitTeacher()->where('status', 1)->get(); @endphp
                                       @if(count($loaded) < 1)
                                             Not Allocated
                                       @else
                                           @foreach($unit->unitTeacher()->where('status', 1)->get() as $key => $lecturer)
                                               <div class="row mb-1">
                                                   <div class="col col-md-8">
                                                      @php $loadcount  =  $workload->where('user_id', $lecturer->user_id)->count(); @endphp
                                                      @php 
                                                        if($lecturer->userTeachingArea->placedUser->first()->employment_terms == 'FT'){
                                                            $maxLoad  =  '7';
                                                        }else{
                                                            $maxLoad  =  '4';
                                                        }
                                                      @endphp

                                                      {{ $loadcount }}/ {{ $maxLoad }}
                                                   </div>
                                                   
                                               </div>
                                           @endforeach
                                       @endif
                                   @else
                                       <div class="row mb-1">
                                           <div class="col col-md-8">
                                            @php $loadcount  =  $workload->where('user_id', $unit->allocateUnit->user_id)->count(); @endphp
                                            @php 
                                              if($unit->allocateUnit->userAllocation->placedUser->first()->employment_terms == 'FT'){
                                                  $maxLoad  =  '7';
                                              }else{
                                                  $maxLoad  =  '4';
                                              }
                                            @endphp

                                            {{ $loadcount }}/ {{ $maxLoad }}
                                               {{-- {{ $unit->allocateUnit->userAllocation->placedUser->first()->employment_terms }} --}}
                                           </div>
                                           
                                       </div>
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

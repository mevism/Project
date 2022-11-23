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
            order: [[2, 'asc']],
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
                        FEE STRUCTURE
                    </h5>
                </div>
                {{-- <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Fee</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            
                        </li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>

 <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">

                <table id="example" class="table table-bordered table-striped js-dataTable-responsive fs-sm">
                    <span class="d-flex justify-content-end">
                        <a class="btn btn-alt-info btn-sm" href="{{ route('courses.kuccpsFee') }}">Create</a>
                    </span><br>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Mode of Study</th>
                            <th>Period</th>
                            <th>Level</th>
                            <th>course</th>
                            <th>Y1SI </th>
                           <td></td>
                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $key =>$item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @if ($item->student_type  == 1)
                                J-FT
                                @else 
                                S-FT      
                                @endif
                            </td>
                            <td>Y{{ $item->year }}S{{ $item->semester }}</td>
                          <td>
                                @if ($item->level  == 1)
                                CERTIFICATE
                                @elseif ($item->level  == 2)
                                DIPLOMA  
                                @elseif ($item->level  == 3)
                                UNDERGRADUATE  
                                @elseif ($item->level  == 4)
                                POSTGRADUATE
                                @else
                                NON-STANDARD 
                                @endif
                            </td>
                            <td>{{ $item->course->course_name }}</td>
                           <td>{{ $item->caution_money +$item->student_union + $item->medical_levy + $item->tuition_fee + $item->industrial_attachment + $item->student_id + $item->examination + $item->registration_fee + $item->library_levy + $item->ict_levy + $item->activity_fee + $item->student_benevolent + $item->kuccps_placement_fee + $item->cue_levy }}</td>
                            <td>
                                <a class="btn btn-sm btn-alt-info" href="{{ route('courses.getFee') }}">view</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                 </table>

            </div>
        </div>
        </div>
    </div>

@endsection('content')
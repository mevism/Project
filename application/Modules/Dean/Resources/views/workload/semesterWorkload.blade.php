@extends('dean::layouts.backend')
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
                        {{ $year }} WORKLOAD
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            workload
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
                    <table id="example" class="table table-bordered table-responsive-sm table-striped table-vcenter js-dataTable-responsive fs-sm">

                        <thead>
                        <th>#</th>
                        {{-- <th>Academic Year </th> --}}
                        <th>department </th>
                        <th>Academic semester</th>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                            @foreach ($department as $dept => $depts)
                                <tr>
                                    <td> {{ $loop->iteration }}</td>

                                    <td>
                                        @foreach($departs as $deptCode)
                                            @if($dept == $deptCode->id )
                                             {{ $deptCode->dept_code }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td nowrap="">

                                        @foreach ($intakes as $academic  => $intake)

                                            <div class="row mb-1">
                                                <div class="col col-md-8">
                                                    {{ $academic }}
                                                </div>
                                                <a class="btn btn-sm btn-outline-secondary"
                                                    href="{{ route('dean.viewWorkload', ['id' => Crypt::encrypt($academic), 'year' => Crypt::encrypt($year), 'dept' => Crypt::encrypt($dept)]) }}"
                                                    >view</a>


                                                        <a class="btn btn-sm btn-outline-success" onclick="return confirm('Are you sure you want to approve this workload there is no reverting ?')"
                                                        href="{{ route('dean.approveWorkload', ['id' => Crypt::encrypt($academic), 'year' => Crypt::encrypt($year)]) }}"
                                                        >Approve
                                                        @if($intake != null)
                                                            @if($intake->first()->dean_status == 1)
                                                                <span class="m-2 text-success">
                                                                    <i class="fa fa-check"></i>
                                                                </span>

                                                            @endif
                                                        @endif
                                                    </a>

                                                    </div>

                                                        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('You are about to  decline this workload there is no reverting?')"data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ preg_replace('~/~', '', $academic) }}
                                                        ">Decline
                                                        @if($intake != null)
                                                            @if($intake->first()->dean_status == 2)
                                                            <span class="m-2 text-danger">
                                                                <i class="fa fa-times"></i>
                                                            </span>


                                                            @endif
                                                        @endif
                                                    </a>


                                                    </div>

                                                    <div class="modal fade" id="staticBackdrop-{{ preg_replace('~/~', '', $academic) }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('dean.declineWorkload', ['id' => Crypt::encrypt($academic), 'year' => Crypt::encrypt($year)]) }}">
                                                                        @csrf
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <div class="col-md-11">
                                                                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                                                                {{-- <input type="hidden" value="{{ $leave->id }}" name="transfer_id"> --}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="submit" class="btn btn-outline-success col-md-5">Submit Remarks</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
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
@endsection

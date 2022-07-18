@extends('layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        APPLICATIONS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Applications</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Applications
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <table id="example" class="display"> --}}
        <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
            @csrf
            @method('delete')
            @if(count($archived)>0)
                <thead>
                    <th>Applicant Name</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Ref. number</th>
                    <th>Status</th>

                </thead>
                <tbody>
                @foreach($archived as $item)
                        <tr>
                            <td> {{ $item->applicant->sname }} {{ $item->applicant->fname }} {{ $item->applicant->mname }}</td>
                            <td> {{ $item->courses->department_id }}</td>
                            <td> {{ $item->courses->course_name }}</td>
                            <td> {{ $item->ref_number }}</td>
                            <td> @if ($item->registrar_status ==1)<a  class="badge badge-sm bg-info" >Archived</a>
                                @endif
                            </td>

                          </tr>

                @endforeach
                </tbody>
            @else
            <tr>
                <small class="text-center text-muted">There are no archived appications</small>
            </tr>
            @endif
    </table>
            </div>

        </div>
    </div>

@endsection

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


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
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('courses.acceptedMail') }}" method="post">
                        @csrf

            <table id="example" class="table table-bordered table-striped js-dataTable-responsive fs-sm">
                @if(count($accepted)>0)
                    <thead>
                    <tr>
                        <th>✔</th>
                         <th></th>
                        <th>Applicant Name</th>
                        <th>Department Name</th>
                        <th>Course</th>
                        <th>Finance</th>
                        <th>Department</th>
                        <th>Registrar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accepted as $item)
                            <tr>
                                <td>
                                    @if($item->registrar_status > 0 )
                                    <input class="accepted" type="checkbox" name="submit[]" value="{{ $item->id }}">
                                        @else

                                    @endif
                                    </td>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $item->applicant->sname }} {{ $item->applicant->fname }} {{ $item->applicant->mname }}</td>
                                <td> {{ $item->courses->getCourseDept->name }}</td>
                                <td> {{ $item->courses->course_name }}</td>
                                <td> @if ($item->finance_status ===1)
                                    <a  class="badge badge bg-success" >Accepted</a>
                                    @elseif($item->finance_status ===2)
                                    <a  class="badge badge bg-danger" >Rejected</a>
                                    @else
                                    <a  class="badge badge bg-primary" >Review</a>
                                    @endif

                                </td>
                                <td> @if ($item->cod_status ===1)
                                    <a  class="badge badge bg-success" >Accepted</a>
                                    @elseif($item->cod_status ===2)
                                    <a  class="badge badge bg-danger" >Rejected</a>
                                    @else
                                    <a  class="badge badge bg-primary" >Review</a>
                                    @endif

                                </td>
                                <td >
                                    @if ($item->registrar_status ===1)
                                    <a  class="badge bg-success" >Accepted</a>
                                    @elseif($item->registrar_status ===2)
                                    <a  class="badge bg-danger" >Rejected</a>
                                    @else
                                    <a  class="badge bg-primary" >Pending</a>
                                    @endif

                                </td>
                                <td nowrap>
                                    @if($item->registrar_status === 0)

                                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.viewApplication', $item->id) }}">view</a>
                                    @else
                                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.preview', $item->id) }}">view</a>
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('courses.viewApplication', $item->id) }}">edit</a>

                                    @endif
                                </td>
                            </td>

                            </tr>

                    @endforeach
                    </tbody>
                @else
                <tr>
                    <small class="text-center text-muted">There are no accepted appications</small>
                </tr>
                @endif
        </table>
        @if(count($accepted)>0)
            <div>
                <input type="checkbox" onclick="for(c in document.getElementsByClassName('accepted')) document.getElementsByClassName('accepted').item(c).checked = this.checked"> Select all
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-sm btn-alt-primary" href="route('courses.archived')" data-toggle="click-ripple">Generate Admission letters </button>
            </div>
            @endif
    </form>


        </div>
            </div>
        </div>
    </div>


@endsection


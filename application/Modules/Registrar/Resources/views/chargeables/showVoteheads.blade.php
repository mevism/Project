@extends('applications::layouts.backend')

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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0">
                        CHARGEABLE   VOTEHEADS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">VOTEHEADS</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page" >
                            VIEW CHARGEABLE VOTEHEADS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

          <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row">
                 <div class="table-responsive col-12">
                    <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-alt-info btn-sm m-2" href="{{ route('courses.addChargeableVotehead') }}">ADD VOTEHEADS</a>
                        </div>
                        <thead>
                            <th>#</th>
                            <th>Code</th>
                            <th>NAME </th>
                            <th>AMOUNT </th>
                            <th>ACTION </th>
                        </thead>
                        <tbody>@foreach ($show as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-transform: uppercase">{{ $item->voteheads->vote_id }}</td>
                                    <td style="text-transform: uppercase">{{ $item->voteheads->vote_name }}</td>
                                    <td style="text-transform: uppercase">{{ number_format((float) $item->amount, 0, '.', ',') }}</td>

                                    <td>
                                        {{-- <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editVotehead', $item->votehead_id) }}"><i class="fa fa-pen-alt mx-1"></i> edit</a> --}}
                                        <a class="btn btn-sm btn-alt-danger" onclick="return confirm('Are you sure you want to delete this votehead?')" href="{{ route('courses.destroyChargeableVotehead', ['id' => $item->chargeable_vote_id]) }}">
                                            <i class="fa fa-trash-alt mx-1"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
          </div>
          <!-- Dynamic Table Responsive -->
        </div>
        <!-- END Page Content -->

@endsection

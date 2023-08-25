@extends('cod::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
<style>
    .form-floating .form-control {
        height: 2.95rem !important;
        padding: 0.75rem 0.75rem 0 0.75rem !important;
        font-size: 0.875rem !important;
    }

    .form-floating label {
        font-size: 0.875rem !important;
    }

</style>
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
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                       {{ strtoupper(Carbon\Carbon::parse($intake->intake_from)->format('MY')) }} COURSE TRANSFERS INTAKES
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course Transfers</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            SEMESTER SETUP
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="d-flex justify-content-center h-50">
                    <div class="col-md-6 mt-5">
                        <form class="form-class" method="POST" action="{{ route('department.storeCourseTransferSetup') }}">
                            @csrf
                            @foreach($classes as $class)
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>{{ $class->name }}</label>
                                    </div>
                                    @if($class->classCourse->level_id == 3)
                                        <div class="form-floating col-md-8 text-uppercase">
                                            <input type="number" class="form-control col-md-12" name="points[{{ $class->name }}]" placeholder="..." step="0.01" @if($class->CutOffPoints !== null) value="{{ $class->CutOffPoints->points }}" @else value="{{ old('points.' . $class->name) }}" @endif>
                                            <label class="mx-3">Class Cutoff Points</label>
                                        </div>
                                    @elseif($class->classCourse->level_id == 2)
                                        <div class="form-floating col-md-8 text-uppercase">
                                            <input type="text" class="form-control col-md-12" name="points[{{ $class->name }}]" placeholder="..." value="{{ old('points.') }}">
                                            <label class="mx-3">Class Cutoff Grade</label>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-md btn-alt-success col-md-7">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
@endsection

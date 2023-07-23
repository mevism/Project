@extends('cod::layouts.backend')
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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        ADD SEMESTER SPECIAL/SUPPLEMENTARY UNITS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">DEPARTMENT</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ADD SUP/SPECIALS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="col-8">
                        <form method="POST" action="{{ route('department.storeSupSpecial') }}">
                            @csrf
                            <div class="row form-inline">
                                <div class="mb-3 form-floating d-inline-block col-md-6">
                                    <input type="text" name="academic" value="{{ $academic }}" class="form-control" readonly placeholder="academic year">
                                    <label class="mx-3">ACADEMIC YEAR</label>
                                </div>
                                <div class="mb-3 form-floating d-inline-block col-md-6">
                                    <input type="text" name="semester" value="{{ $semester }}" class="form-control text-uppercase" readonly placeholder="academic year">
                                    <label class="mx-3">ACADEMIC SEMESTER</label>
                                </div>
                            </div>
                            @foreach($units as $unitCode => $unit)
                                <div class="mb-3">
                                    {{ $loop->iteration }}
                                    <input type="checkbox" name="units[]" value="{{ $unitCode }}" class="form-check-inline" checked placeholder="academic year">
                                    <label>{{ $unitCode }} {{ \Modules\COD\Entities\Unit::where('unit_code', $unitCode)->first()->unit_name }}</label>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-center mt-2">
                                <button type="submit" class="btn btn-md btn-outline-success col-7"> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
@endsection

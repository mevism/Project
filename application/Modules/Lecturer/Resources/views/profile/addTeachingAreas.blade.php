
@extends('lecturer::layouts.backend')
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

    $(document).ready(function() {
        $('#example1').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    $(document).ready(function() {
        $('#example2').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    $(document).ready(function() {
        $('#example3').DataTable( {
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
                        Add Teaching Areas
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Teaching Areas
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
                    @if($highest >= 5)
                        <li class="nav-item">
                            <button class="nav-link active" id="btabs-alt-static-grad-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-grad" role="tab" aria-controls="btabs-alt-static-grad" aria-selected="true">Post Graduate Courses</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-alt-static-under-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-under" role="tab" aria-controls="btabs-alt-static-under" aria-selected="false">Degree Courses</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-alt-static-dip-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-dip" role="tab" aria-controls="btabs-alt-static-dip" aria-selected="true">Diploma Courses</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-alt-static-cert-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-cert" role="tab" aria-controls="btabs-alt-static-cert" aria-selected="false">Certificate Courses</button>
                        </li>
                    @elseif($highest == 4)
                            <li class="nav-item">
                                <button class="nav-link @if($highest == 4) active @endif " id="btabs-alt-static-under-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-under" role="tab" aria-controls="btabs-alt-static-under" aria-selected="false">Degree Courses</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="btabs-alt-static-dip-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-dip" role="tab" aria-controls="btabs-alt-static-dip" aria-selected="true">Diploma Courses</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="btabs-alt-static-cert-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-cert" role="tab" aria-controls="btabs-alt-static-cert" aria-selected="false">Certificate Courses</button>
                            </li>
                    @elseif($highest == 3)
                        <li class="nav-item">
                            <button class="nav-link @if($highest == 3) active @endif " id="btabs-alt-static-dip-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-dip" role="tab" aria-controls="btabs-alt-static-dip" aria-selected="true">Diploma Courses</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-alt-static-cert-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-cert" role="tab" aria-controls="btabs-alt-static-cert" aria-selected="false">Certificate Courses</button>
                        </li>
                    @elseif($highest == 2)
                        <li class="nav-item">
                            <button class="nav-link @if($highest == 2) active @endif " id="btabs-alt-static-cert-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-cert" role="tab" aria-controls="btabs-alt-static-cert" aria-selected="false">Certificate Courses</button>
                        </li>
                    @endif

                </ul>
                <form method="post" action="{{ route('lecturer.storeTeachingAreas') }}">
                    @csrf
                    <div class="block-content tab-content overflow-hidden">
                        @if($highest == 5)
                            <div class="tab-pane fade fade-left show active" id="btabs-alt-static-grad" role="tabpanel" aria-labelledby="btabs-alt-static-grad-tab">
                                <table id="example" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 5 && $firstDigit >= 5 || $firstDigit >= 6)
                                            <tr>
                                                <td> {{ ++$i }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }} </td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-under" role="tabpanel" aria-labelledby="btabs-alt-static-under-tab">
                                <table id="example1" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 4 && $firstDigit == 3 || $firstDigit == 4 )
                                            <tr>
                                                <td> {{ ++$i }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }} </td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                     <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-dip" role="tabpanel" aria-labelledby="btabs-alt-static-dip-tab">
                                <table id="example2" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>Unit Type</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 3 && $firstDigit == 2)
                                            <tr>
                                                <td> {{ ++$i }}</td>

                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-cert" role="tabpanel" aria-labelledby="btabs-alt-static-cert-tab">
                                <table id="example3" class="table table-bordered table-responsive-sm table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 2 && $firstDigit == 1)
                                            <tr>
                                                <td>{{ ++$i }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($highest == 4)
                            <div class="tab-pane fade fade-left show @if($highest == 4) active @endif" id="btabs-alt-static-under" role="tabpanel" aria-labelledby="btabs-alt-static-under-tab">
                                <table id="example1" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 4 && $firstDigit == 3 || $firstDigit == 4 )
                                            <tr>
                                                <td> {{ ++$i }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }} </td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                     <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-dip" role="tabpanel" aria-labelledby="btabs-alt-static-dip-tab">
                                <table id="example2" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>Unit Type</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 3 && $firstDigit == 2)
                                            <tr>
                                                <td> {{ ++$i }}</td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-cert" role="tabpanel" aria-labelledby="btabs-alt-static-cert-tab">
                                <table id="example3" class="table table-bordered table-responsive-sm table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 2 && $firstDigit == 1)
                                            <tr>
                                                <td>{{ ++$i }} </td>

                                                <td> {{ $unit->unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($highest == 3)
                            <div class="tab-pane fade fade-left show @if($highest == 3) active @endif " id="btabs-alt-static-dip" role="tabpanel" aria-labelledby="btabs-alt-static-dip-tab">
                                <table id="example2" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 3 && $firstDigit == 2)
                                            <tr>
                                                <td> {{ ++$i }}</td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade fade-left show" id="btabs-alt-static-cert" role="tabpanel" aria-labelledby="btabs-alt-static-cert-tab">
                                <table id="example3" class="table table-bordered table-responsive-sm table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 2 && $firstDigit == 1)
                                            <tr>
                                                <td> {{ ++$key }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td> {{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($highest == 2)
                            <div class="tab-pane fade fade-left show @if($highest == 2) active @endif " id="btabs-alt-static-cert" role="tabpanel" aria-labelledby="btabs-alt-static-cert-tab">
                                <table id="example3" class="table table-bordered table-responsive-sm table-striped js-dataTable-responsive fs-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>UNIT CODE</th>
                                    <th>UNIT NAME</th>
                                    <th>UNIT TYPE</th>
                                    <th>SELECTED</th>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($units as $key => $unit)
                                        @php
                                            preg_match("/\d/", $unit->unit_code, $matches);
                                            if (isset($matches[0])) {
                                                $firstDigit = $matches[0];
                                            }
                                        @endphp
                                        @if($highest >= 2 && $firstDigit == 1)
                                            <tr>
                                                <td>{{ ++$i }} </td>
                                                <td> {{ $unit->unit_code }} </td>
                                                <td>{{ $unit->unit_name }}</td>
                                                <td>
                                                    @if($unit->type == 1)
                                                        University Unit
                                                    @elseif($unit->type == 2)
                                                        Faculty Unit
                                                    @else
                                                        Department Unit
                                                    @endif
                                                </td>
                                                <td>
                                                  <input type="checkbox" @if(in_array($unit->unit_code, $myAreas)) checked disabled @endif name="units[]" value="{{ $unit->unit_id }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-outline-success col-md-7">Save Teaching Areas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

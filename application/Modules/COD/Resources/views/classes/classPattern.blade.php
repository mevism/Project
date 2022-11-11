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
            order: [[1, 'asc']],
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
                    <h5 class="h5 fw-bold mb-0">
                        CLASSES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">{{ $class->name }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Class Pattern
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

{{--                    <form method="POST">--}}


{{--                        <span class="h6">Class code</span> <span> {{ $class->name }}</span>--}}

{{--                        <fieldset class="border p-2 mb-4">--}}
{{--                            <legend  class="float-none w-auto"> <h5> CLASS DETAILS </h5></legend>--}}
{{--                            <div class="row row-cols-sm-3 g-2">--}}
{{--                                <div class="form-floating mb-4">--}}
{{--                                    <input type="text" class="form-control" name="classcode" readonly value="{{ $class->name }}" placeholder="classcode">--}}
{{--                                    <label>CLASS CODE</label>--}}
{{--                                </div>--}}

{{--                                <div class="form-floating mb-4">--}}
{{--                                    <input type="number" name="capacity" class="form-control" placeholder="class capacity">--}}
{{--                                    <label>CLASS CAPACITY</label>--}}
{{--                                </div>--}}

{{--                                <div class="form-floating mb-4">--}}
{{--                                    <input type="number" name="cutoff" class="form-control" placeholder="class capacity">--}}
{{--                                    <label>CLASS CUT-OFF POINTS</label>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </fieldset>--}}

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Create Pattern
                        </button>
                    </div>

                        <div class="table table-responsive">
                            <table class="table table-responsive-sm table-borderless table-striped fs-sm" id="example">
                                <thead>
                                    <th>#</th>
                                    <th>Class Code</th>
                                    <th>Academic Year</th>
                                    <th>Semester Period</th>
                                    <th>Stage</th>
                                    <th>Semester</th>
                                    <th>Start date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($patterns as $key => $pattern)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $pattern->class_code }}</td>
                                            <td>{{ $pattern->academic_year }}</td>
                                            <td>{{ $pattern->period }}</td>
                                            <td>{{ $pattern->stage }}</td>
                                            <td>{{ $pattern->pattern->season }}</td>
                                            <td>{{ $pattern->start_date }}</td>
                                            <td>{{ $pattern->end_date }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $pattern->id }}">
                                                    Edit
                                                </button>
                                                <a class="btn btn-sm btn-outline-danger" href="{{ route('cod.deleteClassPattern', ['id' => Crypt::encrypt($pattern->id)]) }}">delete</a>

                                                <div class="modal fade" id="staticBackdrop-{{ $pattern->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel"> Edit {{ $pattern->period }} Semester</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @php
                                                                    $semester = explode(' ', $class->classCourse->courseRequirements->course_duration)[0]*3-1;

                                                                    $stage = explode(' ', $class->classCourse->courseRequirements->course_duration)[0];
                                                                @endphp

                                                                <form method="POST" action="{{ route('cod.updateClassPattern', ['id' => Crypt::encrypt($pattern->id)]) }}">
                                                                    @csrf

                                                                    <div class="row row-cols-sm-4 g-2">

                                                                        {{--                            @for($p = 1; $p <= 3; $p++)--}}
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="year">
                                                                                <option value="{{ $pattern->academic_year }}"> {{ $pattern->academic_year }} </option>
                                                                                @for($z = 2020; $z <= 2100; $z++)
                                                                                    <option value="{{ $z.'/'.$z+1 }}">{{ $z.'/'.$z+1 }}</option>
                                                                                @endfor
                                                                            </select>
                                                                            <label>ACADEMIC YEAR</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="period">
                                                                                <option @if($pattern->period == 'SEP/DEC') selected @endif value="SEP/DEC">SEP/DEC</option>
                                                                                <option @if($pattern->period == 'JAN/APR') selected @endif value="JAN/APR">JAN/APR</option>
                                                                                <option @if($pattern->period == 'MAY/AUG') selected @endif value="MAY/AUG">MAY/AUG</option>
                                                                            </select>
                                                                            <label>ACADEMIC SEMESTER</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="stage">
                                                                                <option value="{{ $pattern->stage }}">YEAR {{ $pattern->stage }} </option>
                                                                                @for($x = 1; $x <= $stage; $x++)
                                                                                    <option value="{{ $x }}">YEAR {{ $x }}</option>
                                                                                @endfor
                                                                            </select>
                                                                            <label>YEAR OF STUDY</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select CLASS="form-select" name="semester">
                                                                                <option value="{{ $pattern->pattern_id }}"> {{ $pattern->pattern->season }} </option>
                                                                                @foreach($seasons as $season)
                                                                                    <option value="{{ $season->id }}">{{ $season->season }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <label>SEMESTER OF STUDY</label>
                                                                        </div>

                                                                        <input type="hidden" value="{{ $class->name }}" name="code">
                                                                        {{--                            @endfor--}}
                                                                    </div>

                                                                    <div class="row row-cols-sm-2 g-2">

                                                                        <div class="form-floating mb-2">
                                                                            <input type="date" class="form-control" name="start_date">
                                                                            <label>SEMESTER START DATE</label>
                                                                        </div>

                                                                        <div class="form-floating mb-2">
                                                                            <input type="date" class="form-control" name="end_date">
                                                                            <label>SEMESTER END DATE</label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="d-flex justify-content-center mt-4 mb-4">
                                                                        <button class="btn btn-outline-success">UPDATE CLASS PATTERN</button>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

{{--                        <fieldset class="border p-2 mb-4">--}}
{{--                            <legend  class="float-none w-auto"> <h5> CREATE CLASS PATTERN</h5></legend>--}}

{{--                        @for($i = 1; $i <= $semester; $i++)--}}



{{--                        @endfor--}}

{{--                        <div class="d-flex justify-content-center mt-4 mb-4">--}}
{{--                            <button class="btn btn-alt-success col-md-5" onclick="return confirm('Are you sure you want to upload this class pattern?')" href="#">Publish Class Pattern </button>--}}
{{--                        </div>--}}
{{--                        </fieldset>--}}

{{--                    </form>--}}

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $class->name }} Class Pattern</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $semester = explode(' ', $class->classCourse->courseRequirements->course_duration)[0]*3-1;

                        $stage = explode(' ', $class->classCourse->courseRequirements->course_duration)[0];
                    @endphp

                    <form method="POST" action="{{ route('cod.storeClassPattern') }}">
                        @csrf

                        <div class="row row-cols-sm-4 g-2">

{{--                            @for($p = 1; $p <= 3; $p++)--}}
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="year">
                                        <option selected disabled class="text-center">-- academic year --</option>
                                        @for($z = 2020; $z <= 2100; $z++)
                                            <option value="{{ $z.'/'.$z+1 }}">{{ $z.'/'.$z+1 }}</option>
                                        @endfor
                                    </select>
                                    <label>ACADEMIC YEAR</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="period">
                                        <option selected disabled class="text-center"> -- select semester --</option>
                                        <option value="SEP/DEC">SEP/DEC</option>
                                        <option value="JAN/APR">JAN/APR</option>
                                        <option value="MAY/AUG">MAY/AUG</option>
                                    </select>
                                    <label>ACADEMIC SEMESTER</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="stage">
                                        <option selected disabled class="text-center">-- year of study --</option>
                                        @for($x = 1; $x <= $stage; $x++)
                                            <option value="{{ $x }}">YEAR {{ $x }}</option>
                                        @endfor
                                    </select>
                                    <label>YEAR OF STUDY</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select CLASS="form-select" name="semester">
                                        <option selected disabled class="text-center">-- semester of study --</option>
                                        @foreach($seasons as $season)
                                            <option value="{{ $season->id }}">{{ $season->season }}</option>
                                        @endforeach
                                    </select>
                                    <label>SEMESTER OF STUDY</label>
                                </div>

                                <input type="hidden" value="{{ $class->name }}" name="code">
{{--                            @endfor--}}
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <button class="btn btn-outline-success">CREATE CLASS PATTERN</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

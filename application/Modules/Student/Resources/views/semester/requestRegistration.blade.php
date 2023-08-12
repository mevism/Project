@extends('student::layouts.backend')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

{{--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}
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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        REQUEST REGISTRATION
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">STUDENT PROGRESS</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row row-cols-sm-2 g-2">

                <div class="">
                    <fieldset class="border p-2 mb-4" style="height: 100% !important;">
                        <legend  class="float-none w-auto"> <h6> CURRENT DETAILS </h6></legend>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">STUDENT NAME : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ $student->surname }} {{ $student->first_name }} {{ $student->middle_name }} </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">PHONE NUMBER : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ $student->mobile }} </span>
                    </div>
                        <div class="mb-4">
                            <span class="h5 fs-sm mb-3">STUDENT EMAIL ADDRESS : </span>
                            <span class="h6 fs-sm fw-normal mb-3"> {{ $student->email }} </span>
                        </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">PERSONAL EMAIL ADDRESS : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ $student->email }} </span>
                    </div>
{{--                    <div class="mb-4">--}}
{{--                        <span class="h5 fs-sm mb-3">PHYSICAL ADDRESS : </span>--}}
{{--                        <span class="h6 fs-sm fw-normal mb-3"> P.O BOX {{ $student->address }}-{{ $student->postal_code }} {{ $student->town }}</span>--}}
{{--                    </div>--}}
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">REGISTRATION NUMBER : </span>
                        <span class="h6 fs-sm fw-normal"> {{ $student->student_number }} </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">COURSE ADMITTED : </span>
                        <span class="h6 fs-sm fw-normal"> {{ \Modules\Registrar\Entities\Courses::where('course_id', $student->course_id)->first()->course_name }} </span>
                    </div>

                    <div class="mb-4">
                        @if($reg == null)
                            <span class="text-warning mb-3">Not registered</span>
                        @else
                        <span class="h5 fs-sm mb-3"> YEAR OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ $reg->year_study }}</span>

                        <span class="h5 fs-sm mb-3"> SEMESTER OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ $reg->semester_study }} ({{ $reg->patternRoll->season }})</span>

                        <span class="h5 fs-sm mb-3"> ACADEMIC YEAR : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> {{ \DB::table('academicperiods')->where('intake_id', $reg->intake_id)->first()->academic_year }}</span>
                        @endif
                    </div>
                    </fieldset>
                </div>


                <div class="">

                    @if($next != NULL )
                        <fieldset class="border p-3 mb-4" style="height: 100% !important;">
                            <legend  class="float-none w-auto"> <h6> NEXT SEMESTER DETAILS </h6></legend>
                            <div class="row row-cols-sm-3 g-1 fs-sm">
                                <div class="mb-4">
                                    <span class="fw-semibold">ACADEMIC YEAR : </span> {{ $next->academic_year }}
                                </div>

                                <div class="mb-4">
                                    <span class="fw-semibold">SEMESTER : </span> {{ $next->period }}
                                </div>

                                <div class="mb-4">
                                    <span class="fw-semibold"> STAGE : </span> {{ $next->semester }}
                                </div>
                            </div>

                                @if(in_array($next->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3', '7.3'], true))

                                <fieldset class="border p-2 mb-0">
                                    <legend  class="float-none w-auto"> <h6>  SEMESTER PERIOD </h6></legend>

                                    {{ $next->pattern->season }}
                                </fieldset>

                                @else
                                <form method="POST" action="{{ route('student.registerSemester') }}">
                                <fieldset class="border p-2 mb-0">
                                    <legend  class="float-none w-auto"> <h6>  SEMESTER UNITS </h6></legend>
                                    @foreach($options as $option => $units)
                                        @if($course->course_id == $option)
                                            <h6 class="mb-4">{{ $course->course_name }}</h6>
                                            @foreach($units as $unit)
                                              <p>
                                                <input type="checkbox" name="unit_code[]" checked value="{{ $unit->unit_code }}" onclick="return false;">
                                                  <input type="hidden" name="optionId" value="{{ $option }}">
                                                  {{ $loop->iteration }}. {{ $unit->unit_code }} - {{ $unit->SyllabusUnit->unit_name }}
                                              </p>
                                            @endforeach
                                        @else
                                            <h6 class="mb-2 mt-4">
                                                <label>
                                                    <input type="radio" name="optionId" value="{{ $option }}" class="option-radio">
                                                    {{ \Modules\COD\Entities\CourseOptions::where('option_id', $option)->first()->option_name }}
                                                </label>
                                            </h6>
                                            <div class="units-container">
                                                @foreach($units as $unit)
                                                        <div class="row mb-2">
                                                            <div class="col-md-3">
                                                                <input type="checkbox" @if($unit->type == 'core') checked onclick="return false;" @endif name="unit_code[]" value="{{ $unit->unit_code }}" class="unit-checkbox" data-option="{{ $option }}">
                                                                {{ $loop->iteration }}. {{ $unit->unit_code }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $unit->SyllabusUnit->unit_name }}
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ $unit->type }}
                                                            </div>
                                                        </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                    <small class="text-danger">NB: Number of units selected must match department requirements</small>
                                </fieldset>
                                @endif
                        </fieldset>
                    @else

                        <fieldset class="border p3 mb-4">
                            <legend class="float-none w-auto"><h6> NEXT SEMESTER DETAILS </h6></legend>

                            @if($reg == null)
                                <p class="text-warning text-center h6">Oops! You are not a bona fide student</p>
                            @else

                                @php
                                    $imploded = implode(' ', $list);

                                    $finished = substr($imploded, -3);

                                    $current = $reg->year_study.'.'.$reg->semester_study;
                                    @endphp

                                @if($imploded == null)

                                    <h6 class="text-info text-center">
                                       Oops! Class Schedule not created. Please contact your COD.
                                    </h6>

                                @elseif($finished = $current)

                                    <h6 class="text-success text-center">
                                        Congrats!!! You made it to the last semester of study.
                                    </h6>
{{--                                @elseif()--}}
                                @endif

                            @endif

                        </fieldset>

                    @endif

                </div>
            </div>

            @if($next != NULL)
                    @csrf
                    <input type="hidden" name="semester" value="{{ $next->semester }}">
                    <input type="hidden" name="yearstudy" value="{{ $next->stage}}">
                    <input type="hidden" name="semesterstudy" value="{{ $next->pattern->season_code }}">
                    <input type="hidden" name="period" value="{{ $next->period }}">
                    <input type="hidden" name="academicyear" value="{{ $next->academic_year }}">
                    <input type="hidden" name="pattern" value="{{ $next->pattern_id }}">
                    <div class="d-flex justify-content-center mt-4">
                        @if(in_array($next->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3', '7.3'], true))
                            @if($dates == null)
                                <button class="btn btn-outline-warning col-md-5 disabled"> Semester registration not scheduled </button>
                            @else
                                @php
                                    $today = \Carbon\Carbon::now();
                                @endphp
                                @if($today < $dates->start_date)
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration to open on {{ \Carbon\Carbon::parse($dates->start_date)->format('D, d-M-Y') }}
                                    </button>
                                @elseif($today > $dates->end_date)
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration closed
                                    </button>
                                @elseif($today <= $dates->end_date)
                                    <button class="btn btn-outline-primary col-md-5">Break for {{ $next->pattern->season }} </button>
                                @endif

                            @endif
                        @else
                            @if($dates == null)
                                <button class="btn btn-outline-warning col-md-5 disabled"> Semester registration not scheduled </button>
                            @else
                                @php
                                    $today = \Carbon\Carbon::now();
                                @endphp
                                @if($today < $dates->start_date)
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration to open on {{ \Carbon\Carbon::parse($dates->start_date)->format('D, d-M-Y') }}
                                    </button>
                                @elseif($today > $dates->end_date)
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration closed
                                    </button>
                                @elseif($today <= $dates->end_date)
                                    <button class="btn btn-outline-success col-md-5"> Submit Registration </button>
                                @endif
                            @endif
                        @endif
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
<script>
    $(document).ready(function() {
        $('.unit-checkbox').on('change', function() {
            var selectedOption = $(this).data('option');
            $('.option-radio').prop('checked', false); // Uncheck all option radios
            $('input[name="optionId"][value="' + selectedOption + '"]').prop('checked', true); // Check the selected option radio

            // Disable all unit checkboxes
            $('.unit-checkbox').prop('disabled', true);

            // Enable unit checkboxes for the selected option
            $('.unit-checkbox[data-option="' + selectedOption + '"]').prop('disabled', false);
        });

        $('.option-radio').on('change', function() {
            var selectedOption = $(this).val();

            // Disable all unit checkboxes
            $('.unit-checkbox').prop('disabled', true);

            // Enable unit checkboxes for the selected option
            $('.unit-checkbox[data-option="' + selectedOption + '"]').prop('disabled', false);
        });
    });

</script>





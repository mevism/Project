@extends('student::layouts.backend')

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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        REQUEST REGISTRATION
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
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
                    <fieldset class="border p-2 mb-4">
                        <legend  class="float-none w-auto"> <h6> CURRENT DETAILS </h6></legend>
                    <div class="mb-2">
                        <span class="h5 fs-sm">STUDENT NAME : </span>
                        <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->sname }} {{ Auth::guard('student')->user()->loggedStudent->fname }} {{ Auth::guard('student')->user()->loggedStudent->mname }} </span>
                    </div>
                    <div class="mb-2">
                        <span class="h5 fs-sm">PHONE NUMBER : </span>
                        <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->mobile }} </span>
                    </div>
                    <div class="mb-2">
                        <span class="h5 fs-sm">EMAIL ADDRESS : </span>
                        <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->email }} </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm">PHYSICAL ADDRESS : </span>
                        <span class="h6 fs-sm fw-normal"> P.O BOX {{ Auth::guard('student')->user()->loggedStudent->address }}-{{ Auth::guard('student')->user()->loggedStudent->postal_code }} {{ Auth::guard('student')->user()->loggedStudent->town }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="h5 fs-sm">REG. NUMBER : </span>
                        <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->reg_number }} </span>
                    </div>
                    <div class="mb-2">
                        <span class="h5 fs-sm">COURSE ADMITTED : </span>
                        <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->courseStudent-> studentCourse->course_name }} </span>
                    </div>

                    <div class="mb-2">
                        @if($reg == null)
                            <span class="text-warning">Not registered</span>
                        @else
                        <span class="h5 fs-sm"> YEAR OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal"> {{ $reg->year_study }}</span>

                        <span class="h5 fs-sm"> SEMESTER OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal"> {{ $reg->semester_study }} ({{ $reg->patternRoll->season }})</span>

                        <span class="h5 fs-sm"> ACADEMIC YEAR : </span>
                        <span class="h6 fs-sm fw-normal"> {{ $reg->academic_year }}</span>
                        @endif
                    </div>
                    </fieldset>
                </div>


                <div class="">

                    @if($next != NULL )
                        <fieldset class="border p-3 mb-4">
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
                                <fieldset class="border p-2 mb-0">
                                    <legend  class="float-none w-auto"> <h6>  SEMESTER UNITS </h6></legend>
                                    @foreach($units as $key => $one)
                                        <p> {{ ++$key }}. {{ $one->course_unit_code }} - {{ $one->unit_name }}</p>
                                    @endforeach
                                </fieldset>
                                @endif
                        </fieldset>
                    @else

                        <fieldset class="border p3 mb-4">
                            <legend class="float-none w-auto"><h6> NEXT SEMESTER DETAILS </h6></legend>

                            @if($reg == null)
                                <p class="text-warning text-center">Oops! You are not a bona fide student</p>
                            @else

                                @php
                                    $imploded = implode(' ', $list);

                                    $finished = substr($imploded, -3);

                                    $current = $reg->year_study.'.'.$reg->semester_study;
                                    @endphp

                                @if($finished = $current)

                                    <h5 class="text-success fw-bold text-center">
                                        Congrats!!! You made it to the last semester of study.
                                    </h5>
                                @endif

                            @endif

                        </fieldset>

                    @endif

                </div>
            </div>

            @if($next != NULL)
                <form method="POST" action="{{ route('student.registerSemester') }}">
                    @csrf
                    <input type="hidden" name="semester" value="{{ $next->semester }}">
                    <input type="hidden" name="yearstudy" value="{{ $next->stage}}">
                    <input type="hidden" name="semesterstudy" value="{{ $next->pattern->season_code }}">
                    <input type="hidden" name="period" value="{{ $next->period }}">
                    <input type="hidden" name="academicyear" value="{{ $next->academic_year }}">
                    <input type="hidden" name="pattern" value="{{ $next->pattern_id }}">
                    <div class="d-flex justify-content-center">
                        @if(in_array($next->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3', '7.3'], true))
                            @if($dates === null)
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

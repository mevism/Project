@extends('student::layouts.backend')
<script src="https://code.jquery.com/jquery-3.6.2.js"></script>

@if($stage != null)
<script>

$(document).ready( function (){
    var type = $('#type').val();
    if(type == 1){
        $(document).on('change', '#newclass', function () {
            var class_code = $('#newclass').val();
            var stage = $('#stage').val();
            console.log(class_code);
            $.ajax({
                type: 'get',
                url: '{{ route('student.getLeaveClasses') }}',
                data: { class_code:class_code, stage:stage },
                dataType: 'json',
                success:function (data){

                    console.log(data)

                    var dates = data.period.split("/");
                    var newDate = dates[dates.length, 0];

                    if(newDate == 'SEP'){

                        console.log('its sept');

                        var years = data.academic_year.split("/");
                        var newYear = years[years.length, 0];

                    }else {

                        console.log('its not sept');

                        var years = data.academic_year.split("/");
                        var newYear = years[years.length, 1];
                    }

                    $('#enddate').val(newYear + '-' + newDate + '-01')
                    // $('#enddate').val(newDate)
                    $('#newClass').val(data.class_code)
                    $('#newacademic').val(data.academic_year)
                    $('#newSemester').val(data.period)
                    $('#newStage').val(data.semester)

                },

                error: function (){

                },

            });

        });
    }else {

        var stage = {{ $stage->year_study.'.'.$stage->semester_study }};

        if(stage == 1.1) {

            var studentNumber = '{{ $student->student_id }}';

            $.ajax({
                type: 'get',
                url: '{{ route('student.defermentRequest') }}',
                data: {studNumber: studentNumber},
                dataType: 'json',
                success: function (data) {

                    var oldclass = data.deferment.class_code.split("/")
                    var edittedclass = oldclass[oldclass.length, 1].slice(-4)
                    var newcls = data.deferment.class_code.replace(edittedclass, parseInt(edittedclass) + 1)
                    var newyear = data.period.academic_year.split("/")
                    var yearstart = parseInt(newyear[newyear.length, 0]) + 1
                    var yearend = parseInt(newyear[newyear.length, 1]) + 1
                    var dated = data.period.intake_month.slice(0, -4)

                    console.log(yearend)

                    $('#mynewclass').val(newcls)
                    $('#newClass').val(newcls)
                    $('#newStage').val(data.deferment.year_study + '.' + data.deferment.semester_study)
                    $('#newSemester').val(data.period.intake_month)
                    $('#newacademic').val(yearstart + '/' + yearend)
                    $('#enddate').val(yearstart + '-' + dated + '-01')
                }

            });

        }else {
            var studentNumber = '{{ $student->student_id }}';
            var semesters = ['SEP/DEC', 'JAN/APR', 'MAY/AUG'];
            $.ajax({
                type: 'get',
                url: '{{ route('student.defermentRequest') }}',
                data: {studNumber: studentNumber},
                dataType: 'json',
                success: function (data) {

                    var oldclass = data.deferment.class_code.split("/")
                    var edittedclass = oldclass[oldclass.length, 1].slice(-4)
                    var newcls = data.deferment.class_code.replace(edittedclass, parseInt(edittedclass) + 1)

                    var newyear = data.period.academic_year.split("/")
                    var yearstart = parseInt(newyear[newyear.length, 0]) + 1
                    var yearend = parseInt(newyear[newyear.length, 1]) + 1
                    var enddates = data.period.intake_month.split("/")
                    var dated = enddates[enddates.length, 0]

                    index = semesters.indexOf(data.period.intake_month);
                    if(index >= 0 && index < semesters.length - 1)
                        nextItem = semesters[index]
                    var newsemesters = nextItem.split("/");

                    $('#mynewclass').val(newcls)
                    $('#newClass').val(newcls)
                    $('#newStage').val(stage)
                    $('#newSemester').val(nextItem)
                    $('#newacademic').val(yearstart + '/' + yearend)
                    $('#enddate').val(yearend + '-' + newsemesters[newsemesters.length, 0] + '-01')
                }

            });
        }
    }

});
</script>

@endif

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0">
                        ACADEMIC LEAVES
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">STUDENT PROGRESS</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            REQUEST ACADEMIC LEAVE/DEFERMENT
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Floating Labels -->
    <div class="block block-rounded">
        <div class="block-content block-content-full">

            <!-- Labels on top -->
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> CURRENT STUDENT COURSE DETAILS</h6></legend>
                            <div class="mb-4">
                                <span class="h5 fs-sm">STUDENT NAME : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->surname }} {{ $student->first_name }} {{ $student->middle_name }} </span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">PHONE NUMBER : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->mobile }} </span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">EMAIL ADDRESS : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->email }} </span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">PHYSICAL ADDRESS : </span>
                                <span class="h6 fs-sm fw-normal"> P.O BOX {{ $student->address }}-{{ $student->postal_code }} {{ $student->town }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">STUDENT NUMBER : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->student_number }} </span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">COURSE ADMITTED : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->EnrolledStudentCourse->course_name }} </span>
                            </div>

                            <div class="mb-4">
                                    <span class="h5 fs-sm">CURRENT CLASS : </span>
                                    <span class="h6 fs-sm fw-normal"> {{ $student->current_class }} </span>
                            </div>

                            <div class="mb-4">
                                @if($stage == null)
                                    <span class="text-warning h6">
                                        Not registered
                                    </span>
                                @else
                                <span class="h5 fs-sm"> YEAR OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $stage->year_study }}</span>

                                <span class="h5 fs-sm"> SEMESTER OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $stage->semester_study }} ({{ $stage->patternRoll->season }})</span>
                                @endif
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 space-y-4">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto">
                                    <h5 class="fw-bold text-center"> LEAVE/DEFERMENT DETAILS</h5>
                                </legend>
                                @if($stage == null)
                                    <span class="text-warning h6">
                                        You cannot apply for leave unless you are registered
                                    </span>
                                @elseif($list == null)
                                    <h6 class="text-info text-center">
                                        Oops! Class Schedule not created. Please contact your COD.
                                    </h6>
                                @else
                                    <!-- Form Labels on top - Default Style -->
                                    <form action="{{ route('student.submitacademicleaverequest') }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-2">
                                            <select name="type" id="type" class="form-control form-control-lg form-select mb-2 department" readonly="">
                                                @if($stage->year_study.'.'.$stage->semester_study > 1.2)
                                                    <option value="1">ACADEMIC LEAVE </option>
                                                @else
                                                    <option value="2">DEFERMENT</option>
                                                @endif
                                            </select>
                                            <label>LEAVE TYPE</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            @if($stage->year_study.'.'.$stage->semester_study > 1.2)
                                            <select name="class" id="newclass" class="form-control form-select">
                                                <option selected disabled class="text-center"> -- choose class -- </option>
                                                    @foreach($classes as $name => $newClass)
                                                        <option >{{ $name }}</option>
                                                    @endforeach
                                            </select>
                                            <input type="hidden" name="stage" id="stage" value="{{ $stage->year_study.'.'.$stage->semester_study }}">
                                            <label>UPCOMING CLASSES </label>
                                            @else
                                            <input type="text" readonly class="form-control" name="class" id="mynewclass">
                                            <label>UPCOMING CLASSES </label>
                                            @endif
                                        </div>
                                        <input type="hidden" name="intake" value="{{ $intake->intake_id }}">
                                        <div class="form-floating mb-2">
                                            <input type="text" name="start_date" value="{{ \Carbon\Carbon::now()->format('Y-M-d') }}" class="form-control" readonly>
                                            <label>LEAVE START DATE</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" name="end_date" id="enddate" value="{{ old('end_date') }}" class="form-control" readonly>
                                            <label>LEAVE END DATE</label>
                                        </div>

                                        <div class="d-flex justify-content-center mb-2">
                                            <div class="col-md-10">
                                                <div class="row mb-1">
                                                    <div class="col-md-6 fs-sm fw-semibold">New Class Code</div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="newClass" id="newClass" readonly style="outline: none; border: none transparent;">
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col-md-6 fs-sm fw-semibold">Academic Year </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="newAcademic" id="newacademic" readonly style="outline: none; border: none transparent;">
                                                    </div>
                                                </div>

                                                <div class="row mb-1 ">
                                                    <div class="col-md-6 fs-sm fw-semibold">Semester of Study</div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="newSemester" id="newSemester" readonly style="outline: none; border: none transparent;">
                                                    </div>
                                                </div>

                                                <div class="row mb-1 ">
                                                    <div class="col-md-6 fs-sm fw-semibold">Joint at Stage</div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="newStage" id="newStage" readonly style="outline: none; border: none transparent;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="current_class" value="{{ $student->current_class }} ">

                                        <div class="form-floating mb-2">
                                            <textarea class="form-control" style="height: 100px;" name="reason" placeholder="reasons">{{ old('reason') }}</textarea>
                                            <label>Reason for requesting leave</label>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-center">
                                                @if($event == null)
                                                    <button class="btn btn-outline-primary col-md-10 disabled m-2" >NOT SCHEDULED</button>
                                                @else
                                                    @if($event->start_date > $dates)

                                                        <button class="btn btn-outline-info col-md-10 disabled m-2" >SCHEDULE TO OPENS ON {{ \Carbon\Carbon::parse($event->start_date)->format('D, d-M-Y') }} </button>

                                                    @elseif($event->end_date >= $dates)

                                                        <button class="btn btn-outline-success col-md-10 m-2" >SUBMIT LEAVE REQUEST</button>

                                                    @else
                                                        <button class="btn btn-outline-danger col-md-10 disabled m-2" >SCHEDULE CLOSED {{ \Carbon\Carbon::parse($event->end_date)->format('D, d-M-Y') }} </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Form Labels on top - Default Style -->
                                @endif
                            </fieldset>
                        </div>
                    </div>
                </div>
                <!-- END Labels on top -->
            </div>
        </div>
    </div>
    <!-- END Floating Labels -->
@endsection

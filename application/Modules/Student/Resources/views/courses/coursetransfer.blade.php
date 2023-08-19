@extends('student::layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        Course Transfer
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt text-uppercase">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Request Transfer
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
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> CURRENT COURSE DETAILS</h6></legend>
                            <div class="mb-4">
                                <span class="h5 fs-sm">STUDENT NAME : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->surname.' '.$student->first_name.' '.$student->middle_name }} </span>
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
                                <span class="h5 fs-sm">REG. NUMBER : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->student_number }} </span>
                            </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">COURSE ADMITTED : </span>
                                <span class="h6 fs-sm fw-normal"> {{\auth()->guard('student')->user()->enrolledCourse->StudentsCourse->course_name }} </span>
                            </div>

                            <div class="mb-4">
                                @if($stage == null)
                                    Not registered
                                @else
                                <span class="h5 fs-sm"> YEAR OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $stage->year_study }}</span>

                                <span class="h5 fs-sm"> SEMESTER OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $stage->semester_study }} ({{ $stage->patternRoll->season }})</span>
                                @endif
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 space-y-0">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> NEW COURSE DETAILS</h6></legend>
                            <!-- Form Labels on top - Default Style -->
                                @if( $stage == null)
                                    <span class="text-warning text-center">
                                        You cannot request course transfer, ask to be registered first
                                    </span>
                                @else
                                    @if($stage->year_study.".".$stage->semester_study > '1.1')

                                        <span class="text-warning text-center">
                                        Course transfers are done only at year 1 semester 1
                                        </span>
                                    @else
                                        <form action="{{ route('student.submittransferrequest') }}" method="POST">
                                            @csrf
                                            <div class="d-flex justify-content-center">
                                                <div class="col-md-11">
                                                    <div class="mb-0">
                                                        <label class="mb-2">DEPARTMENT</label>

                                                        <select name="dept" class="form-control form-control-lg form-select mb-2 department">
                                                            <option selected disabled class="text-center"> -- select department -- </option>
                                                            @foreach($departments as $key => $department)
                                                                <option value="{{ $department->department_id }}"> {{ $department->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        <label class="mb-2">COURSE</label>

                                                        <select name="course" class="form-control form-control-lg form-select mb-3 course">
                                                            <option selected disabled class="text-center"> -- select course -- </option>
                                                        </select>

                                                        <label class="mb-2">CLASS</label>

                                                        <select name="class" class="form-control form-control-lg mb-3 class">
                                                            <option selected disabled class="text-center"> -- select class -- </option>
                                                        </select>
                                                        <label class="mb-2 label">CLASS CUT-OFF POINTS</label>
                                                        <input type="text" id="points" class="form-control mb-3" name="points" readonly>

                                                        <label class="mb-2 label">MY POINTS</label>
                                                        <input type="text" id="mypoints" class="form-control mb-3" name="mypoints" readonly value="{{ old('points') }}">
                                                        <input type="hidden" value="{{ $intake }}" name="intake">
                                                    </div>

                                                    <div class="mb-2" id="requirements">
                                                        <label class="mb-3">COURSE MINIMUM SUBJECT REQUIREMENT</label>
                                                        <input type="text" id="subject1" readonly style="border: none transparent; outline: none !important;">
                                                        <input type="text" id="subject2" readonly style="border: none transparent; outline: none !important;">
                                                        <hr>
                                                        <input type="text" id="subject3" readonly style="border: none transparent; outline: none !important;">
                                                        <input type="text" id="subject4" readonly style="border: none transparent; outline: none !important;">
                                                        <hr>
                                                    </div>

                                                    <div class="mb-2" id="grades">
                                                        <label>COURSE MINIMUM GRADE</label>
                                                        <input name="mingrade" type="text" id="mingrade" class="form-control mb-3" readonly>

                                                        <label class="mb-2">MY KCSE GRADE</label>
                                                        <select id="mygrade" name="mygrade" class="form-control form-select" required>
                                                            <option class="text-center" selected disabled> -- select your grade -- </option>
                                                            <option value="KCSE A">KCSE A</option>
                                                            <option value="KCSE A-">KCSE A-</option>
                                                            <option value="KCSE B+">KCSE B+</option>
                                                            <option value="KCSE B">KCSE B</option>
                                                            <option value="KCSE B-">KCSE B-</option>
                                                            <option value="KCSE C+">KCSE C+</option>
                                                            <option value="KCSE C">KCSE C</option>
                                                            <option value="KCSE C-">KCSE C-</option>
                                                            <option value="KCSE D+">KCSE D+</option>
                                                            <option value="KCSE D">KCSE D</option>
                                                            <option value="KCSE D-">KCSE D-</option>
                                                        </select>
                                                    </div>

                                                    <div id="info" class="alert alert-info alert-dismissible fs-sm" role="alert">
                                                        <p><b>Note!</b> Ensure that you meet all the minimum subject requirement and minimum min-grade for the course you want to transfer to. Only students who meet the minimum requirements will be considered. <br> <span class="text-warning">You will be invoiced Ksh. 500 which you will be required to pay to complete application for course transfer.</span></p>
                                                    </div>

                                                    <div id="success" class="alert alert-success alert-dismissible fs-sm" role="alert">
                                                        <p><b>Congratulations!!</b> You meet the minimum course cut-off points for this course. Click "Submit Button" to complete request. <br>
                                                            <span class="text-warning">You will be invoiced Ksh. 500 which you will be required to pay to complete application for course transfer.</span>
                                                        </p>
                                                    </div>

                                                    <div id="warning" class="alert alert-warning alert-dismissible fs-sm" role="alert">
                                                        <p><b>Oops!!</b> You do not meet the minimum course cut-off points for the selected course. Please choose another course that you qualify.<br>
                                                            <span class="text-danger">However, if you wish to continue, you will be invoiced Ksh. 500 which you will be required to pay to complete application for course transfer.</span>
                                                        </p>
                                                    </div>
                                                    @if($event == NULL)
                                                        <div class="mb-4">
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-primary col-md-7 disabled" > Course transfer not scheduled </button>
                                                            </div>
                                                        </div>
                                                    @else

                                                        @php
                                                            $now = \Carbon\Carbon::now();
                                                        @endphp

                                                        @if($now < $event->start_date)
                                                            <div class="mb-4">
                                                                <div class="d-flex justify-content-center">
                                                                    <button class="btn btn-outline-info col-md-10 disabled">  Course Transfer Schedule starts on {{ Carbon\Carbon::parse($event->start_date)->format('D, d M Y') }}</button>
                                                                </div>
                                                            </div>
                                                        @elseif($now > $event->end_date)
                                                            <div class="mb-4">
                                                                <div class="d-flex justify-content-center">
                                                                    <button class="btn btn-outline-danger col-md-7 disabled" >Course transfer schedule closed </button>
                                                                </div>
                                                            </div>
                                                        @elseif($now <= $event->end_date)
                                                            <div class="mb-4">
                                                                <div class="d-flex justify-content-center">
                                                                    <button class="btn btn-outline-success col-md-7"  onclick="return confirm('Are you sure you want to proceed? You will be invoiced for submitting this request.')"> Submit Course Transfer Request </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    @endif
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
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<script>
    $(document).ready( function (){

        $("#success").hide();
        $("#warning").hide();
        $("#points").hide();
        $("#mypoints").hide();
        $(".label").hide();
        $("#grades").hide();
        $("#requirements").hide();
        $("#info").hide();

        $(document).on('change', '.department', function () {

            var department_id = $(this).val();
            var div = $(this).parent();
            var op = " ";

            $.ajax({

                type: 'get',
                url: '{{ route('student.getdeptcourse') }}',
                data: { id:department_id},
                success:function (data){

                    console.log(data)

                    op+='<option value="0" selected disabled class="text-center"> -- choose course -- </option>'

                    for (var i = 0; i < data.length; i++){

                        op+='<option value="'+data[i].course_id+'"> '+data[i].course_name+'</<option>';                           ''
                    }

                    div.find('.course').html(" ");
                    div.find('.course').append(op);
                },

                error: function (){

                },

            });

        });

        $(document).on('change', '.course', function () {

            var course_id = $(this).val();
            var a = $(this).parent();

            console.log(course_id);
            var op1 = " ";
            var op2 = " "

            $.ajax({

                type: 'get',
                url: '{{ route('student.getcourseclasses') }}',
                data: { id:course_id},
                // dataType: 'json',
                success:function (data) {

                    console.log(data)

                    // op1+='<option value="" selected class="text-center"> data[i].name</option>'

                    // for (var i = 0; i < data.length; i++){

                    op1 += '<option selected value="' + data[0] + '"> ' + data[1] + '</<option>';
                    // op2+='<option selected value="'+data[2]+'"> '+data[2]+'</<option>';                           ''
                    // }

                        if (data[7] == 2) {
                            $("#points").hide();
                            $("#mypoints").hide();
                            $(".label").hide()
                            $("#grades").show()
                            $("#requirements").show()

                            a.find('.class').html(" ");
                            a.find('.class').append(op1);
                            $("#mingrade").val(data[6]);
                            $("#subject1").val(data[2]);
                            $("#subject2").val(data[3]);
                            $("#subject3").val(data[4]);
                            $("#subject4").val(data[5]);

                            $("#info").show();


                        } else{
                            $("#points").show();
                            $("#mypoints").show();
                            $(".label").show()
                            a.find('.class').html(" ");
                            a.find('.class').append(op1);
                            // a.find('#points').append(data[2]);
                            $('#points').val(data[3]);
                            $('#mypoints').val(data[2]);

                            // a.find("class").append(data);

                            if (data[2] >= data[3]) {
                                $("#warning").hide();
                                $("#success").show();
                            } else {
                                $("#success").hide();
                                $("#warning").show();
                            }
                    }
                },

                error: function (){

                },

            });

        });

    });
</script>






























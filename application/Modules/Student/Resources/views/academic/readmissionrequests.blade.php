@extends('student::layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h6 class="h6 fw-bold mb-0">
                        COURSE Readmission
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Request Admission
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
                    <div class="row ">
                        <div class="col-lg-6">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto">
                                    <h6 class="fw-bold text-center"> CURRENT COURSE DETAILS</h6>
                                </legend>
                            <div class="mb-2">
                                <span class="h5 fs-sm">STUDENT NAME : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->sname }} {{ $student->fname }} {{ $student->mname }} </span>
                            </div>
                            <div class="mb-2">
                                <span class="h5 fs-sm">PHONE NUMBER : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->mobile }} </span>
                            </div>
                            <div class="mb-2">
                                <span class="h5 fs-sm">EMAIL ADDRESS : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->email }} </span>
                            </div>
                                <div class="mb-2">
                                    <span class="h5 fs-sm">STUDENT EMAIL : </span>
                                    <span class="h6 fs-sm fw-normal"> {{ $student->student_email }} </span>
                                </div>
                            <div class="mb-4">
                                <span class="h5 fs-sm">PHYSICAL ADDRESS : </span>
                                <span class="h6 fs-sm fw-normal"> P.O BOX {{ $student->address }}-{{ $student->postal_code }} {{ $student->town }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="h5 fs-sm">STUDENT NUMBER : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->student_number }} </span>
                            </div>
                            <div class="mb-2">
                                <span class="h5 fs-sm">COURSE ADMITTED : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $student->course_name }} </span>
                            </div>

                                <div class="mb-2">
                                    <span class="h5 fs-sm">CURRENT CLASS : </span>
                                    <span class="h6 fs-sm fw-normal"> {{ $student->current_class }} </span>
                                </div>

                            <div class="mb-2">
                                @if($student->studentRegistration == null)
                                    <span class="text-warning">Not registered</span>
                                @else
                                <span class="h5 fs-sm"> YEAR OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $current->year_study }}</span>

                                <span class="h5 fs-sm"> SEMESTER OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ $current->semester_study }} {{ "( ".$current->patternRoll->season." ) " }}</span>
                                @endif
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 space-y-4">
                            <fieldset class="border p-2"  style="height: 100% !important;">
                                <legend class="float-none w-auto">
                            <h6 class="fw-bold text-center"> RE-ADMISSION DETAILS</h6>
                                </legend>
                                @if($student->studentRegistration == null)
                                    <span class="text-warning">
                                        You can not request for readmission unless you are registered
                                    </span>
                                @else

                                    @if($admission == null)

                                        <span class="text-center text-info">
                                            Oop! You cannot request for readmission. You have no records of deferment, suspension or discontinuation
                                        </span>

                                    @else

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <h1 class="h6 fs-sm">LEAVE TYPE</h1>
                                            </div>
                                            <div class="col-md-8 fs-sm">
                                                @if($admission->type == 1)
                                                    ACADEMIC LEAVE
                                                @elseif($admission->type == 2)
                                                    DEFERMENT
                                                @elseif($admission->type == 3)
                                                    SUSPENSION
                                                @else
                                                    DISCONTINUATION
                                                @endif

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h1 class="h6 fs-sm">LEAVE EXPIRY DATE</h1>
                                            </div>
                                            <div class="col-md-8 fs-sm">
                                                {{ $admission->to }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h1 class="h6 fs-sm">READMISSION CLASS</h1>
                                            </div>
                                            <div class="col-md-8 fs-sm">
                                                {{ $admission->differed_class }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h1 class="h6 fs-sm">JOINING AT </h1>
                                            </div>
                                            <div class="col-md-8 fs-sm">
                                                <p><b>ACADEMIC YEAR :</b> {{ $admission->differed_year }}</p>
                                                <p><b>STAGE :</b> {{ $admission->stage }}</p>
                                                <p><b>ACADEMIC SEMESTER :</b> {{ $admission->differed_semester }}</p>
                                            </div>
                                        </div>

                                    @endif
                            @endif
                            <!-- END Form Labels on top - Default Style -->
                            </fieldset>
                        </div>
                    </div>

                    @if($admission != null)
                        <div class="d-flex justify-content-center mt-4">
                            @if($dates == null)
                                <a class="btn btn-outline-info col-md-7" disabled="">Readmissions not scheduled</a>
                            @else
                                @if(in_array($student->status, ['1', '2'], true))
                                    <a class="btn btn-outline-warning col-md-7"> You are not eligible to apply for admission </a>
                                @else
                                    @if($dates->start_date > \Carbon\Carbon::today())
                                        <a class="btn btn-outline-info col-md-7" disabled="">Readmission's schedule to open on {{ \Carbon\Carbon::parse($dates->start_date)->format('D, d-M-Y') }}</a>

                                    @elseif($dates->end_date < Carbon\Carbon::today())
                                        <a class="btn btn-outline-danger col-md-7" disabled="">Readmission's schedule closed on {{ \Carbon\Carbon::parse($dates->end_date)->format('D, d-M-Y') }}</a>
                                    @else
                                        <a class="btn btn-outline-success col-md-7" href="{{ route('student.storereadmissionrequest', $admission->leave_id) }}">Request readmission </a>
                                    @endif

                                @endif
                            @endif
                        </div>
                    @endif
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

        $(document).on('change', '.department', function () {

            var department_id = $(this).val();
            var div = $(this).parent();
            var op = " ";

            $.ajax({

                type: 'get',
                url: '{{ route('student.getdeptcourse') }}',
                data: { id:department_id},
                success:function (data){
                    op+='<option value="0" selected disabled class="text-center"> -- choose course -- </option>'

                    for (var i = 0; i < data.length; i++){

                        op+='<option value="'+data[i].id+'"> '+data[i].course_name+'</<option>';                           ''
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

            $.ajax({

                type: 'get',
                url: '{{ route('student.getcourseclasses') }}',
                data: { id:course_id},
                // dataType: 'json',
                success:function (data){

                    console.log(data);

                    op1+='<option value="0" selected disabled class="text-center"> -- choose course -- </option>'

                    for (var i = 0; i < data.length; i++){

                        op1+='<option value="'+data[i].id+'"> '+data[i].name+'</<option>';                           ''
                    }


                    a.find('.class').html(" ");
                    a.find('.class').append(op1);

                    // a.find("class").append(data);
                },

                error: function (){

                },

            });

        });

    });
</script>

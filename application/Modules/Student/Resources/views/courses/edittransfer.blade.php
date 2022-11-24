@extends('student::layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        Course Transfer
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
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
                            <h5 class="fw-bold text-center"> CURRENT COURSE DETAILS</h5>
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
                                <span class="h5 fs-sm"> YEAR OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->nominalRoll->year_study }}</span>

                                <span class="h5 fs-sm"> SEMESTER OF STUDY : </span>
                                <span class="h6 fs-sm fw-normal"> {{ Auth::guard('student')->user()->loggedStudent->nominalRoll->semester_study }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6 space-y-4">
                            <!-- Form Labels on top - Default Style -->
                            <form action="{{ route('student.updatetransferrequest', ['id' => Crypt::encrypt($transfer->id)]) }}" method="POST">
                                @csrf
                                <div class="mb-0">
                                    <label class="mb-2">DEPARTMENT</label>

                                    <select name="dept" class="form-control form-control-lg form-select mb-2 department">
                                        <option value="{{ $transfer->department_id }}" selected> {{ $transfer->deptTransfer->name }} </option>
                                        @foreach($departments as $key => $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}</option>
                                        @endforeach
                                    </select>

                                    <label class="mb-2">COURSE</label>

                                    <select name="course" class="form-control form-control-lg form-select mb-3 course">
                                        <option value="{{ $transfer->course_id }}" selected> {{ $transfer->courseTransfer->course_name  }} </option>
                                    </select>

                                    <label class="mb-2">CLASS</label>

                                    <select name="class" class="form-control form-select form-control-lg mb-3 class">
                                        <option value="{{ $transfer->class_id }}" selected> {{ $transfer->classTransfer->name }} </option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3">CUT-OFF POINTS</label>
                                    <input type="text" class="form-control mb-3" name="points" value="{{ $transfer->points }}">
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success col-md-7" >SUBMIT TRANSFER REQUEST</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Form Labels on top - Default Style -->
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

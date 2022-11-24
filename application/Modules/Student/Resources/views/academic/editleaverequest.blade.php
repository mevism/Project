@extends('student::layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        ACADEMIC LEAVES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
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
                            <h5 class="fw-bold text-center"> CURRENT STUDENT COURSE DETAILS</h5>
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
                            <h5 class="fw-bold text-center"> LEAVE/DEFERMENT DETAILS</h5>
                            <!-- Form Labels on top - Default Style -->
                            <form action="{{ route('student.updateleaverequest', ['id' => Crypt::encrypt($leave->id)]) }}" method="POST">
                                @csrf
                                <div class="form-floating mb-2">
                                    <select name="type" class="form-control form-control-lg form-select mb-2 department">
                                        <option @if($leave->type == 1) selected @endif value="1">ACADEMIC LEAVE</option>
                                        <option @if($leave->type == 2) selected @endif value="2">DEFERMENT</option>
                                    </select>
                                    <label>LEAVE TYPE</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="start_date" value="{{ $leave->from }}" class="form-control">
                                    <label>START DATE</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="end_date" value="{{ $leave->to }}" class="form-control">
                                    <label>END DATE</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <textarea class="form-control" style="height: 100px;" name="reason" placeholder="reasons">{{ $leave->reason }}</textarea>
                                    <label>Reason for requesting leave</label>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success col-md-7" >SUBMIT LEAVE REQUEST</button>
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

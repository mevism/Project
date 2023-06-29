@extends('cod::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course Options</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Add Option
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                        <form method="post" action="{{ route('department.storeCourseOption') }}">
                            @csrf
                            <div class="d-flex justify-content-center">
                            <div class="col-md-7 mt-4">
                                <h6 class="fw-bold mb-6">
                                    {{ $course->course_name }}
                                </h6>
                                <div class="mb-4 form-floating">
                                    <input type="text" name="name" class="form-control" placeholder="option name">
                                    <label>OPTION NAME</label>
                                </div>
                                <div class="mb-4 form-floating">
                                    <input type="text" name="option_code" class="form-control" placeholder="option code">
                                    <label>OPTION CODE (optional) </label>
                                </div>
                                <input type="hidden" value="{{ $course->course_id }}" name="course_id">
                                <div class="mb-4 d-flex justify-content-center">
                                    <button class="btn btn-md btn-alt-success">Save Course Option</button>
                                </div>
                            </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

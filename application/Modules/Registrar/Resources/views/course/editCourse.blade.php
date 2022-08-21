@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light" xmlns="http://www.w3.org/1999/html">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
          <div class="flex-grow-0">
              <h5 class="h5 fw-bold mb-0">
                  Edit Course
              </h5>
          </div>
      </div>
  </div>
</div>
    <div class="content">
      <div class="block block-rounded">
            <div class="block-header block-header-default">
              <h5 class="block-title">Add Course</h5>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.updateCourse',$data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="col-lg-8 space-y-2">
                        <div class="form-floating col-12 col-xl-12 mb-4">
                            <select name="campus" id="campus" value="{{ old('campus') }}" class="form-control form-control-sm text-uppercase">
                              <option selected value="{{ $data->campus_id }}"> {{ $data->campus_id }}</option>
                              @foreach ($campuses as $campus)
                              <option value="{{ $campus->name }}">{{ $campus->name }}</option>
                            @endforeach
                            <label class="form-label">CAMPUS</label>
                            </select>
                          </div>
                        <div class="form-floating col-12 col-xl-12">
                            <select name="department" id="department" class="form-control form-control-alt text-uppercase">
                                <option selected value="{{ $data->department_id }}" > {{ $data->department_id }} </option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                                @endforeach
                                <label class="form-label">DEPARTMENT</label>
                            </select>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <select name="level" id="level"value="{{ old('level') }}" class="form-control form-control-alt text-uppercase form-select">
                                <option selected value="{{ $data->level }}">
                                    @if($data->level == 1)
                                        CERTIFICATE
                                    @elseif($data->level == 2)
                                        DIPLOMA
                                    @elseif($data->level == 3)
                                        DEGREE
                                    @elseif($data->level == 5)
                                        MASTERS
                                    @else
                                        PhD
                                    @endif
                                </option>
                                <option value="1">Certificate</option>
                                <option value="2">Diploma</option>
                                <option value="3">Degree</option>
                                <option value="4">Masters</option>
                                <option value="5">PhD</option>
                                <label class="form-label">LEVEL</label>
                            </select>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_name"value = "{{$data->course_name}}" name="course_name" placeholder="Course Name">
                            <label class="form-label">COURSE NAME</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_code" value = "{{$data->course_code}}" name="course_code" placeholder="Course Code">
                            <label class="form-label">COURSE CODE</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_duration" value = "{{$data->course_duration}}"name="course_duration" placeholder="Course Duration">
                            <label class="form-label">COURSE DURATION</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <textarea value = "{{$data->course_requirements}}" class = "form-control form-control-alt text-uppercase" id="course_requirements" name="course_requirements" placeholder="Course Requirements"></textarea>
                            <label class="form-label">COURSE REQUIREMENTS</label>
                        </div>
                    </div>
                    <div class="col-lg-4 space-y-2">
                        <div class="form-floating col-12 col-xl-12">
                            <input type="text" value = "{{$data->subject1}}" class="form-control form-control-alt text-uppercase" id="subject1" name="subject1" placeholder="subject1">
                            <label class="form-label">SUBJECT 1</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <input type="text"value = "{{$data->subject2}}"class="form-control form-control-alt text-uppercase" id="subject2" name="subject2" placeholder="subject2">
                            <label class="form-label">SUBJECT 2</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <select value = "{{$data->subject3}}" name="subject3" id="subject3"class="form-control form-control-alt form-select text-uppercase">
                                <option value="" selected disabled>Choose One Humanity</option>
                                <option value="Geo">Geo</option>
                                <option value="His">His</option>
                                <option value="CRE">CRE</option>
                                <label class="form-label">SUBJECT 3</label>
                            </select>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                            <select value = "{{$data->subject4}}" name="subject4" id="subject4"class="form-control form-select form-control-alt text-uppercase">
                                <option value="" selected disabled>Choose One Science</option>
                                <option value="Phy">Phy</option>
                                <option value="Chem">Chem</option>
                                <option value="Bio">Bio</option>
                                <label class="form-label">SUBJECT 4</label>
                            </select>
                        </div>
                        <p class="p-2">

                            <b>KEY:</b>  <br>
                            Format to key in cluster subjects <br>
                            <span class="small">
                        MAT B+, ENG A-
                      </span>

                        </p>
                    </div>
                </div>
                <div class="col-12 text-center p-3">
                    <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Course</button>
                </div>
            </form>
            </div>
      </div>
    </div>
@endsection

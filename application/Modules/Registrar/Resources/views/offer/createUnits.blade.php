@extends('registrar::layouts.backend')


@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <h4 class="h3 fw-bold mb-2 block-title">
              ADD UNIT to {{  $course->course_name }}
                </h4>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Units</a>
                    </li>
                    {{-- <li class="breadcrumb-item" aria-current="page">
                      <a  href="syllabus">View Units</a>
                    </li> --}}
                </ol>
            </nav>
        </div>
    </div>
  </div>
  <div class="content">
    <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
          <div class="block-content block-content-full">
            <div class="row">
              <div class="d-flex justify-content-center">
              <div class="col-lg-6 space-y-0">

                 <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeCreatedUnits') }}" method="POST">
                  @csrf
                  <div class="form-floating col-12 col-xl-12">
                    <input type="text" value="{{ old('course_unit_code') }}"  class="form-control form-control-alt text-uppercase" id="course_unit_code" name="course_unit_code" placeholder="Course Unit Code">
                    <label class="form-label"> UNIT CODE</label>
                  </div>
                  <input type="hidden" value="{{ $course->course_code }}" name="course_code">
                  <div class="form-floating col-12 col-xl-12">
                    <input type="text" value="{{ old('unit_name') }}"  class="form-control form-control-alt text-uppercase" id="unit_name" name="unit_name" placeholder="Unit Name">
                    <label class="form-label">UNIT NAME</label>
                  </div>
                  <div class="form-floating col-12 col-xl-12">
                    <input type="text" value="{{ old('stage') }}"  class="form-control form-control-alt text-uppercase" id="stage" name="stage" placeholder="Stage">
                    <label class="form-label">STAGE</label>
                  </div>
                  <div class="form-floating col-12 col-xl-12">
                    <input type="text" value="{{ old('semester') }}"  class="form-control form-control-alt text-uppercase" id="semester" name="semester" placeholder="Semester">
                    <label class="form-label">SEMESTER</label>
                  </div>
                  <div class="form-floating col-12 col-xl-12">
                    <input type="text" value="{{ old('type') }}"  class="form-control form-control-alt text-uppercase" id="type" name="type" placeholder="Type">
                    <label class="form-label">TYPE</label>
                  </div>
                  <div class="col-12 text-center p-3">
                    <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Unit</button>
                  </div>
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
  </div> 
@endsection

@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="h3 fw-bold mb-2">

              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Classes</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showClasses">View Classes</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD CLASS</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeClasses') }}" method="POST">
                    @csrf

                    <div class="form-floating col-12 col-xl-12">
                      <select name="attendance"  class="form-control form-control-alt">
                        <option selected disabled> Select Attendance</option>

                          @foreach($attendances as $attend)
                              <option value="{{ $attend->attendance_code }}">{{ $attend->attendance_name }}</option>
                          @endforeach
                          <label class="form-label">ATTENDANCE CODE</label>
                      </select>
                    </div>
                    <div class="form-floating col-12 col-xl-12">
                      <select name="intake_from" class="form-control form-control-alt">
                        <option selected disabled>Select Intake</option>
                        @foreach ($intakes as $intake)
                          <option value="{{ $intake->intake_from }}">{{ Carbon\Carbon::parse($intake->intake_from)->format('M-Y') }} - {{ Carbon\Carbon::parse($intake->intake_to)->format('M-Y') }}</option>
                        @endforeach
                        <label class="form-label">INTAKE NAME</label>
                      </select>
                    </div>
                    <div class="form-floating col-12 col-xl-12">
                      <select name="course" id="course" class="form-control form-control-alt">
                        <option selected disabled> Select Course</option>
                        @foreach ($courses as $item)
                          <option value="{{ $item->course_code }}">{{ $item->course_name }}</option>
                        @endforeach
                        <label class="form-label">COURSE NAME</label>
                      </select>
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Class</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
@endsection

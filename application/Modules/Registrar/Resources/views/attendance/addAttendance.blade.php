@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="">

              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Attendance</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showAttendance">View Attendances</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD ATTENDANCE</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeAttendance') }}" method="POST">
                    @csrf

                    <div class="col-12 col-xl-12">
                      <input type="text" class="form-control form-control-alt" value="{{ old('attendance_name') }}"id="attendance_name" name="attendance_name" placeholder="Attendance Name">
                    </div>
                    <div class="col-12 col-xl-12">
                      <input type="text" class="form-control form-control-alt"  value="{{ old('attendance_code') }}"id="attendance_code" name="attendance_code" placeholder="Attendance Code">
                    </div>

                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Attendance</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection

@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h6 class="h6 fw-bold">
                  ADD MODE OF STUDY
              </h6>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Mode of Study</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showAttendance">View Mode of Study</a>
                  </li>
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
                       <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeAttendance') }}" method="POST">
                        @csrf
                        <div class="form-floating col-12 col-xl-12">
                          <input type="text" class="form-control form-control-alt" value="{{ old('name') }}"id="name" name="name" placeholder="Name">
                          <label class="form-label">MODE OF STUDY</label>
                        </div>
                        <div class="form-floating col-12 col-xl-12">
                          <input type="text" class="form-control form-control-alt"  value="{{ old('code') }}"id="code" name="code" placeholder="Code">
                          <label class="form-label">CODE</label>
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
    </div>
@endsection

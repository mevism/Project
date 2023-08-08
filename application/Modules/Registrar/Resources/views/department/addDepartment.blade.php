@extends('registrar::layouts.backend')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <h6 class="h6 fw-bold mb-0">
             ADD DEPARTMENT
          </h6>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx text-uppercase" href="javascript:void(0)">Department</a>
                  </li>
                  <li class="breadcrumb-item text-uppercase" aria-current="page">
                    <a  href="showDepartment">ADD Departments</a>
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

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeDepartment') }}" method="POST">
                    @csrf

                      <div class="form-floating col-12 col-xl-12">
                      <select name="school" class="form-control text-uppercase">
                        <option selected disabled> Select School </option>
                        @foreach ($schools as $school)
                        <option value="{{ $school->school_id }}">{{ $school->name }}</option>
                        @endforeach
                      </select>
                          <label class="form-label">SCHOOL NAME</label>
                      </div>

                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ old('dept_code') }}"  class="form-control text-uppercase" id="dept_code" name="dept_code" placeholder="Department code">
                      <label class="form-label">DEPARTMENT CODE</label>
                    </div>

                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ old('name') }}"  class="form-control text-uppercase" id="name" name="name" placeholder="Department Name">
                      <label class="form-label">DEPARTMENT NAME</label>
                    </div>

                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Department</button>
                    </div>
                  </form>
                </div>
            </div>
              </div>
            </div>
          </div>
    </div>
@endsection

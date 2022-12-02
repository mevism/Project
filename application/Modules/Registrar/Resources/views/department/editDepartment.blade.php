@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">

        <div class="flex-grow-1">
          <h4 class="h3 fw-bold mb-2 block-title">
            Edit department
          </h4>
      </div>

      </div>
  </div>
</div>
<div class="content">
  <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
        <div class="block-content block-content-full">
          <div class="row">
                <div class="d-flex justify-content-center">
                <div class="col-lg-6 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.updateDepartment', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                     <div class="form-floating col-12 col-xl-12">
                      <select name="school" class="form-control form-control-alt text-uppercase">
                        <option selected value="{{ $data->school_id }}"> {{ $data->schools->name }}</option>
                        @foreach ($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                        <label class="form-label">SCHOOL NAME</label>
                      </select>
                    </div>
                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ $data->dept_code }}"  class="form-control form-control-alt text-uppercase" id="dept_code" name="dept_code" placeholder="Department code">
                      <label class="form-label">DEPARTMENT CODE</label>
                    </div>
                     <div class="form-floating col-12 col-xl-12">
                      <input type="text" class="form-control form-control-alt text-uppercase"value="{{ $data->name }}" id="name" name="name" placeholder="Department Name">
                      <label class="form-label">DEPARTMENT NAME</label>
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Department</button>
                    </div>
                  </form>
                </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection

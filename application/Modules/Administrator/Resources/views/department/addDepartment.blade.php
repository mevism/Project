@extends('registrar::layouts.backend')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD DEPARTMENT</h3>
            </div>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Department</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showDepartment">Add Departments</a>
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

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('admin.storeDepartment') }}" method="POST">
                    @csrf
                       <div class="form-floating col-12 col-xl-12">
                           <select name="division" class="form-control text-uppercase" id="division">
                               <option selected disabled> Select Division </option>
                               @foreach ($divisions as $division)
                                   <option value="{{ $division->name }}">{{ $division->name }}</option>
                               @endforeach
                           </select>
                           <label class="form-label">DIVISION NAME</label>
                       </div>
                      <div class="form-floating col-12 col-xl-12" id="school">
                      <select name="school" class="form-control text-uppercase" >
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

<script>
    $(document).ready(function() {
        $('#school').hide();

        $('#division').on('change', function (){
            var academicValue = $('#division').val();

            if (academicValue == 'ACADEMIC DIVISION'){
                $('#school').show();
            }else {
                $('#school').hide();
            }

        })
    });
</script>

@extends('registrar::layouts.backend')


@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <h6 class="block-title">EDIT MODE OF STUDY</h6>
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

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.updateAttendance',$data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                   <div class="form-floating col-12 col-xl-12">
                      <input type="text" class="form-control form-control-alt" value="{{ $data->attendance_name }}" id="name" name="name" placeholder="Name">
                      <label class="form-label"> MODE OF STUDY</label>
                    </div>
                   <div class="form-floating col-12 col-xl-12">
                      <input type="text" class="form-control form-control-alt" value="{{ $data->attendance_code }}"id="code" name="code" placeholder="Attendance Code">
                      <label class="form-label"> CODE</label>
                    </div>

                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Create Mode of Study</button>
                    </div>
                  </form>
                </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection

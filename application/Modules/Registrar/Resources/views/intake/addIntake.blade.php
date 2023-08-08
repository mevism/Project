@extends('registrar::layouts.backend')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@section('content')
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1 text-uppercase">
                    <h6 class="h6 fw-bold"> ADD Semester to {{ \Carbon\Carbon::parse($years->year_start)->format('Y') }}/{{ \Carbon\Carbon::parse($years->year_end)->format('Y') }} </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Semester</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                          <a  href="showIntake">View Semester</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
</div>
    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">
                   <form action="{{ route('courses.storeIntake', $years->year_id) }}" method="POST">
                    @csrf
                    <div class="row d-flex justify-content-center">
                      <input type="hidden" name="year" value="{{ $years->year_id }}">
                      <div class="form-floating col-12 col-xl-12 mb-2" >
                          <input type="date" class="form-control" name="intake_name_from" placeholder="Intake From">
                          <label class="form-label">SEMESTER START</label>
                        </div>

                        <div class="form-floating col-10 col-xl-12 mb-2">
                          <input type="date" class="form-control" name="intake_name_to" placeholder="Intake To">
                          <label class="form-label">SEMESTER END</label>
                        </div>
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Semester</button>
                    </div>
                  </form>

              </div>
            </div>
          </div>
    </div>
@endsection



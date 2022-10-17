@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="">

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
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD Semester</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form action="{{ route('courses.storeIntake') }}" method="POST">
                    @csrf
                    <div class="row d-flex justify-content-center">

                      <div class="form-floating col-12 col-xl-12">
                        <select name="year" class="form-control form-control-alt text-uppercase">
                          <option selected disabled> Select Year </option>
                          @foreach ($years as $year)
                          <option value="{{ $year->id }}">{{ $year->year_start }}</option>        
                          @endforeach
                          <label class="form-label">ACADEMIC YEAR</label>
                        </select>
                      </div>

                      <div class="form-floating col-12 col-xl-12 mb-2">
                          <input type="date" class="form-control form-control-sm" id="intake_name_from" name="intake_name_from" placeholder="Intake From">
                          <label class="form-label">SEMESTER START</label>
                        </div>
                        <br><br>
                        <div class="form-floating col-10 col-xl-10 mb-2">

                          <input type="date" class="form-control form-control-sm" id="intake_name_to" name="intake_name_to" placeholder="Intake To">
                          <label class="form-label">SEMESTER END</label>
                        </div>
                    </div>
                <BR>

                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Semester</button>
                    </div>
                  </form>

              </div>
            </div>
          </div>
    </div>
@endsection



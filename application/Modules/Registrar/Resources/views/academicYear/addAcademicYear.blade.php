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
                            <a class="link-fx" href="javascript:void(0)">Academic Year</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                          <a  href="academicYear">View Academic Years</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
</div>

    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD ACADEMIC YEAR</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeYear') }}" method="POST">
                    @csrf
                    <div class="row">

                      <div class="form-floating col-12 col-xl-12 mb-2">

                          <input type="date" class="form-control form-control-sm" id="year_start" name="year_start" placeholder="Year From">
                          <label class="form-label">Year FROM</label>
                        </div>
                        <br><br>
                        <div class="form-floating col-12 col-xl-12 mb-2">

                          <input type="date" class="form-control form-control-sm" id="year_end" name="year_end" placeholder="Year To">
                          <label class="form-label">Year TO</label>
                        </div>
                    </div>
                <BR>

                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Academic Year</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
@endsection




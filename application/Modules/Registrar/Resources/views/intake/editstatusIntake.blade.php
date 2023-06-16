@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1 text-uppercase">
                    <h6 class="h6 fw-bold mb-0">EDIT {{ Carbon\Carbon::parse($data->intake_from)->format('MY') }} STATUS</h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update Intake Status
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
</div>

    <div class="content">
      <div  class="block block-rounded col-md-12 col-lg-12 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row">
                  <div class="d-flex justify-content-center">
                      <div class="col-lg-6 space-y-0">
                          <form action="{{ route('courses.statusIntake', $data->intake_id) }}" method="POST">
                              @csrf
                              <div class="row">
                                  <div class="col-12 mt-7">
                                      <select name="status"  class="form-control form-select-lg form-control-alt">
                                          <option @if ($data->status == 0) selected @endif value="0">Pending</option>
                                          <option @if ($data->status == 1) selected @endif value="1">Active</option>
                                          <option @if ($data->status == 2) selected @endif value="2">Completed</option>
                                          <option @if ($data->status == 3) selected @endif value="3">Suspended</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-12 text-center mt-4">
                                  <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Submit</button>
                              </div>
                          </form>
                      </div>
                  </div>
            </div>
      </div>
@endsection



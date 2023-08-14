@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
          <h6 class="h6 fw-bold mb-0 text-uppercase">
            EDIT CALENDER OF EVENTS
          </h6>
      </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt text-uppercase">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Events Calender</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showCalenderOfEvents">Update Event</a>
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
                <div class="col-lg-8 space-y-0">

                   <form action="{{ route('courses.updateCalenderOfEvents', ['id'=> Crypt::encrypt($data->id)]) }}" method="POST">
                    @csrf
                     @method('PUT')
                       <div class="form-floating mb-3 col-12 col-xl-12">
                           <select name="intake" class="form-control  text-uppercase">
                               <option selected value="{{ $data->intake_id }}">{{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $data->intake_id)->first()->intake_month }} - {{ \Illuminate\Support\Facades\DB::table('academicperiods')->where('intake_id', $data->intake_id)->first()->academic_year }}</option>
                               @foreach ($intakes as $intake)
                                   <option value="{{ $intake->intake_id }}">{{ $intake->intake_month }} - {{ $intake->academic_year }}</option>
                               @endforeach
                           </select>
                           <label class="form-label">ACADEMIC SEMESTER</label>
                       </div>

                      <div class="form-floating col-12 col-xl-12 mb-3">
                        <select name="events" class="form-control text-uppercase">
                          <option selected value="{{ $data->event_id }}"> {{ $data->events->name }} </option>
                          @foreach ($events as $event)
                          <option value="{{ $event->id }}">{{ $event->name }}</option>
                          @endforeach
                          <label class="form-label">EVENT NAME</label>
                        </select>
                      </div>

                      <div class="form-floating col-12 col-xl-12 mb-2" >
                        <input type="date" class="form-control" value="{{ $data->start_date}}" id="start_date" name="start_date" placeholder="Start Date">
                        <label class="form-label">START DATE</label>
                      </div>

                      <div class="form-floating col-10 col-xl-12 mb-2">
                        <input type="date" class="form-control" value="{{ $data->end_date }}" name="end_date" placeholder="End Date">
                        <label class="form-label">END DATE</label>
                      </div>

                    <div class="col-12 text-center p-3 mb-4">
                      <button type="submit"  class="btn btn-alt-success" data-toggle="click-ripple">Update Calender Event</button>
                    </div>
                  </form>

                </div>
               </div>
              </div>
            </div>
          </div>
    </div>

@endsection


@extends('lecturer::layouts.backend')
@section('content')

    <div class="bg-image" style="background-image: url( {{ url('media/photos/photo12@2x.jpg')}} );">
      <div class="bg-black-50">
        <div class="content content-full text-center">
          <div class="my-3">
            <img class="img-avatar img-avatar-thumb" src="{{ url('media/avatars/avatar13.jpg')}}" alt="">
          </div>
          <h1 class="h2 text-white mb-0">{{ auth()->guard('user')->user()->title }} {{ auth()->guard('user')->user()->last_name }} {{ auth()->guard('user')->user()->first_name }} {{ auth()->guard('user')->user()->middle_name }}</h1>
          <span class="text-white-75">Lecturer</span>
        </div>
      </div>
    </div>
    <!-- END Hero -->

   

    <!-- Page Content -->
    <div class="content content-boxed">
      <div class="row">
        <div class="col-md-7 col-xl-8">
          <!-- Updates -->
          <ul class="timeline timeline-alt py-0">
            <li class="timeline-event">
              <div class="timeline-event-icon bg-default">
                <i class="fa fa-id-card"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Personal Details</h3>
                  <div class="block-options">
                  </div>
                </div>
                <div class="block-content">
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Name:</div>
                        <div class="col-md-8">{{ auth()->guard('user')->user()->title }} {{ auth()->guard('user')->user()->last_name }} {{ auth()->guard('user')->user()->first_name }} {{ auth()->guard('user')->user()->middle_name }}
                        </div>
                </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Staff No:</div>
                        <div class="col-md-8">{{ auth()->guard('user')->user()->staff_number }}</div>
                </div>
                <div class="row m-2 fs-sm" >
                    <div class="col-md-4">Gender:</div>
                    <div class="col-md-8"> @if (auth()->guard('user')->user()->gender=='F')
                        Female
                         @else Male
                         @endif</div>
            </div>
              </div>
            </li>
            <li class="timeline-event">
              <div class="timeline-event-icon bg-modern">
                <i class="fa fa-phone"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Contant Details</h3>
                  <div class="block-options">
                  </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Phone Number:</div>
                        <div class="col-md-8">{{ auth()->guard('user')->user()->phone_number }}</div>
                </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Office Email:</div>
                        <div class="col-md-8">{{ auth()->guard('user')->user()->office_email }}</div>
                </div>
                <div class="row m-2 fs-sm" >
                    <div class="col-md-4">Personal Email:</div>
                    <div class="col-md-8">{{ auth()->guard('user')->user()->personal_email }}</div>
            </div>
                </div>
              </div>
            </li>
            <li class="timeline-event">
              <div class="timeline-event-icon bg-info">
                <i class="fa fa-briefcase"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Department Details</h3>
                </div>
                <div class="block-content">
                    @foreach(auth()->guard('user')->user()->placedUser as $employment )
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Department:</div>
                        <div class="col-md-9">
                            {{ $employment->userDepartment->name }}
                    </div>
                    </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Station:</div>
                        <div class="col-md-9">
                            {{ $employment->userDepartment->name }}
                        </div>
                    </div>

                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Role:</div>
                        <div class="col-md-9">
                             {{ $employment->userRole->name }}
                        </div>
                    </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Contract:</div>
                        <div class="col-md-9">
                             {{ $employment->employment_terms }}
                        </div>
                    </div>
                    <hr>
                    @endforeach
            
                </div>
              </div>
            </li>
          
          </ul>
          <!-- END Updates -->
        </div>
        <div class="col-md-5 col-xl-4">
          <!-- Products -->
          <div class="block block-rounded">
            <div class="block-header block-header-default">
              <h3 class="block-title">
                <i class="fa fa-briefcase text-muted me-1"></i> Qualifications
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                  
                </button>
              </div>
            </div>
            <div class="block-content">
                @foreach($qualifications as $key =>$qualification)
              <div class="d-flex align-items-center push">
                    <div class="flex-shrink-0 me-3">
                    <a class="item item-rounded fs-lg" href="javascript:void(0)">
                        <i class="fa fa-book"></i> 
                    </a>
                    </div>
                <div class="flex-grow-1">
                  <div class="fw-semibold">{{ $qualification ->level}}</div>
                  <div class="fs-sm">{{ $qualification ->qualification}}</div>
                </div>
              </div>
                @endforeach
              </div>
            </div>
          </div>
          <!-- END Products -->
        </div>
      </div>
    </div>
    <!-- END Page Content -->
  
@endsection
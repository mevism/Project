@extends('application::layouts.backend')
@section('content')
    <div class="bg-image" style="background-image: url({{ url('media/photos/photo33@2x.jpg') }});">
        <div class="bg-black-50">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ asset('/media/avatars/avatar14.jpg') }}" alt="">
                </div>
                <h1 class="h2 text-white mb-0">{{ Auth::user()->sname }}, {{ Auth::user()->mname }} {{ Auth::user()->fname }}</h1>
                <span class="text-white-75"> Applicant </span>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-boxed">
        <div class="row">
            <div class="col-md-7 col-xl-8">
                <!-- Updates -->
                <ul class="timeline timeline-alt py-0">
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-default">
                            <i class="fa fa-user-gear"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Personal Info</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p class="fw-bold mb-2 text-uppercase text-center">
                                    {{ Auth::user()->title }}
                                    {{ Auth::user()->sname }}
                                    {{ Auth::user()->mname }}
                                    {{ Auth::user()->fname }}
                                </p>
                                <div class="row">
                                    <div class="col-4 fw-semibold">Gender </div>
                                    <div class="col-8"> <p>:  @if(Auth::user()->gender = 'M') MALE @elseif(Auth::user()->gender = 'F') FEMALE @else OTHER @endif  </p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold">ID/Birth/Passport No.</div>
                                    <div class="col-8 text-capitalize"> <p>: {{ Auth::user()->id_number }}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold"> Index/Registration No. </div>
                                    <div class="col-xl-8"> <p>: {{ Auth::user()->index_number }}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold">Marital Status </div>
                                    <div class="col-8 text-capitalize"> <p>: {{ Auth::user()->marital_status }}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold"> Living with disability </div>
                                    <div class="col-xl-8"> <p>: {{ Auth::user()->disabled }}</p></div>
                                </div>

                                @if(Auth::user()->disabled == 'Yes')
                                <div class="row">
                                    <div class="col-4 fw-semibold">Type of Disability </div>
                                    <div class="col-8"> <p>: {{ Auth::user()->disability }}</p></div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-modern">
                            <i class="fa fa-contact-card"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Contact Info</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                <p class="fw-semibold mb-2">
                                    Primary Email: {{ Auth::user()->email }}
                                </p>
                                <p>Primary Mobile: {{ Auth::user()->mobile }}</p>
                                <p>Secondary Mobile: {{ Auth::user()->alt_mobile }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-info">
                            <i class="fa fa-address-book"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Physical Address</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p>Nationality:
                                    @if(Auth::user()->nationality = 'KE')
                                        KENYAN
                                    @elseif(Auth::user()->nationality = 'UG')
                                        UGANDAN
                                    @elseif(Auth::user()->nationality = 'TZ')
                                        TANZANIAN
                                    @else
                                        NON-EAST AFRICA STUDENT
                                    @endif
                                </p>
                                <p>County: {{ Auth::user()->county }}</p>
                                <p>Sub County: {{ Auth::user()->sub_county }}</p>
                                <p>Town: {{ Auth::user()->town }}</p>
                                <p>Address: {{ Auth::user()->address }} - {{ Auth::user()->postal_code }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-dark">
                            <i class="fa fa-cog"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Account Details</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p class="fw-semibold mb-2">
                                    Username: {{ Auth::user()->username }}
                                </p>
                                <p>
                                    Account activated at: {{ Auth::user()->email_verified_at }}
                                </p>
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
                            <i class="fa fa-school text-muted me-1"></i> previous applications
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        @foreach($apps as $app)
                            <div class="d-flex align-items-center push">
                                <div class="flex-shrink-0 me-3">
                                <a class="item item-rounded bg-info" href="javascript:void(0)">
                                    <i class="fa fa-book-open-reader fa-2x text-white-75"></i>
                                </a>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $app->courses->course_name }}</div>
                                    <div class="fs-sm">{{ $app->courses->course_requirements }}</div>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center push">
                            <button type="button" class="btn btn-sm btn-alt-secondary">View More..</button>
                        </div>
                    </div>
                </div>
                <!-- END Products -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection

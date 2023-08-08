@extends('application::layouts.backend')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    $(document).ready(function() {
        $('#example1').DataTable( {
            responsive: true,
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );

    function showoptios() {
        var x = document.getElementById("institution");
        if (x.style.display== "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function addwork(){
        var x = document.getElementById('work');
        if(x.style.display== 'none'){
            x.style.display = 'block';
        }else {
            x.style.display = 'none';
        }
    }

    $(document).ready(function (){
        $('div.secondary').hide();
        $('div.tertiary').hide();

        $('input[name=institution]').on('click', function () {
            var selectedValue = $('input[name=institution]:checked').val();

            if(selectedValue == 'secondary') {
                $('div.secondary').show();
                $('div.tertiary').hide();
            }else if(selectedValue == 'tertiary'){
                $('div.tertiary').show();
                $('div.secondary').hide();
            }
        });
    });
</script>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Applications
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Apply
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-boxed">
        <div class="row">
            <div class="col-sm-12">
                <!-- Vertical Block Tabs Default Style -->
                <div class="block block-rounded row g-0">
                    <ul class="nav nav-tabs nav-tabs-block flex-md-column col-md-3" role="tablist">
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start @if($mycourse == null) active @endif  " id="btabs-vertical-require-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-require" role="tab" aria-controls="btabs-vertical-require" aria-selected="false">
                                <i class="fa fa-fw fa-briefcase opacity-50 me-1 d-none d-sm-inline-block"></i> Course Requirements
                                @if($mycourse != null)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>

                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start" id="btabs-vertical-course-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-course" role="tab" aria-controls="btabs-vertical-course" aria-selected="true">
                                <i class="fa fa-fw fa-book-atlas opacity-50 me-1 d-none d-sm-inline-block"></i> Course Details
                                @if($mycourse != null)
                                <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start @if(count($education) <= 0 && $mycourse != null) active @endif " id="btabs-vertical-education-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-education" role="tab" aria-controls="btabs-vertical-education" aria-selected="false">
                                <i class="fa fa-fw fa-school opacity-50 me-1 d-none d-sm-inline-block"></i> Education History
                                @if(count($education) > 0)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start" id="btabs-vertical-work-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-work" role="tab" aria-controls="btabs-vertical-work" aria-selected="false">
                                <i class="fa fa-fw fa-briefcase opacity-50 me-1 d-none d-sm-inline-block"></i> Working History
                                @if(count($work) > 0)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>
{{--                        {{ $mycourse->receipt }}--}}
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start" id="btabs-vertical-fee-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-fee" role="tab" aria-controls="btabs-vertical-fee" aria-selected="false">
                                <i class="fa fa-fw fa-money-bill opacity-50 me-1 d-none d-sm-inline-block"></i> Application Fees
{{--                                @if($mycourse != null)--}}
                                @if($mycourse != null && $mycourse->applicationApproval != null && $mycourse->applicationApproval->finance_status == 1)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @else
                                    <span class="badge bg-info"><i class="fa fa-circle-info"></i> How to pay</span>
                                @endif
{{--                                @endif--}}
                            </button>
                        </li>
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start" id="btabs-vertical-sponsor-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-sponsor" role="tab" aria-controls="btabs-vertical-sponsor" aria-selected="false">
                                <i class="fa fa-fw fa-user-group opacity-50 me-1 d-none d-sm-inline-block"></i> Sponsor / Guardian
                                @if(count($parent) > 0 && count($sponsor) > 0)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start @if($mycourse != null && $mycourse->applicationApproval == null && count($education) > 0) active @endif " id="btabs-vertical-submit-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-submit" role="tab" aria-controls="btabs-vertical-submit" aria-selected="false">
                                <i class="fa fa-fw fa-check-double opacity-50 me-1 d-none d-sm-inline-block"></i> Complete Application
                                @if($mycourse != null && $mycourse->applicationApproval != null && count($education) > 0)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Submitted </span>
                                @endif
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content col-md-9">
                        <div class="block-content tab-pane @if($mycourse == null) active @endif " id="btabs-vertical-require" role="tabpanel" aria-labelledby="btabs-vertical-work-tab">
                            <h4 class="fw-semibold"> Course Requirements </h4>
                            <h4 class="fs-sm fw-semibold">Minimum Course Requirements</h4>

                            <p class="text-amethyst-darker">{{ $course->course_requirements }} </p>

                            <h4 class="fs-sm fw-semibold"> Minmimum Subject Requirements</h4>
                            <span class="h4 fs-sm">Subject 1</span> - <span class="ml-4">{{ $course->subject1 }}</span> <br>
                            <span class="h4 fs-sm">Subject 2</span> - <span class="ml-4">{{ $course->subject2 }}</span> <br>
                            <span class="h4 fs-sm">Subject 3</span> - <span class="ml-4">{{ $course->subject3 }}</span> <br>
                            <span class="h4 fs-sm">Subject 4</span> - <span class="ml-4">{{ $course->subject4 }}</span>

                            <p class="text-danger mt-4">
                                Disclaimer here!!!!!!!!!!!!!!!!!!!!!
                            </p>
                        </div>
                        <div class="block-content tab-pane" id="btabs-vertical-course" role="tabpanel" aria-labelledby="btabs-vertical-home-course">
                            <h4 class="fw-semibold">Course Details</h4>
                            <form method="POST" action="{{ route('application.submitApp') }}">
                                @csrf
                            <div class="row my-1">
                                <label class="col-sm-2 col-form-label" for="example-hf-password">Course Name</label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-md" name="course" value="{{ $course->course_name }}" readonly>
                                </div>
                            </div>
                            <div class="row my-1">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Department</label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-md" name="department" value="{{ $course->OnofferCourse->getCourseDept->name }}" readonly>
                                    <input type="hidden" name="school" value="{{ $course->OnofferCourse->getCourseDept->schools->first()->school_id }}">
                                </div>
                            </div>
                            <div class="row my-1">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">School</label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-md" name="" value="{{ $course->OnofferCourse->getCourseDept->schools->first()->name }}" readonly>
                                    <input type="hidden" name="intake" value="{{ $course->intake_id }}">
                                    <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                                </div>
                            </div>
                            <div class="row" style="padding: 5px !important;">
                                <label class="col-sm-2 col-form-label" for="example-hf-password">Campus</label>
                                <div class="col-sm-10 text-uppercase mb-4" style="padding: 5px !important;">
                                    <div class="space-x-0">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">{{ $course->name }}</label>
                                            <input class="form-check-input" type="radio" name="campus" value="{{ $course->campus_id }}" checked readonly="readonly">
                                        </div>
                                        <h6 class="fs-sm text-info fw-normal mt-2"> You can go courses list to see if this course is offered in another campus </h6>
                                    </div>
                                </div>
                            </div>
                                <h4 class="fw-semibold">Course Requiremets</h4>
                                <div class="row mt-2 mb-4">
                                    <div class="col-md-4">
                                        <span class="h6">KCSE OR Equivalent</span>
                                    </div>
                                    <div class="col-md-8">
                                        <span class="h5 text-info"> {{ $course->course_requirements }} </span>
                                     </div>
                                </div>
                            <span class="h5 fw-semibold">Cluster Subject</span>
                            <span class="fs-sm">
                                <sup class="fs-sm text-danger text-lowercase mt-2">*</sup>
                                provide your KCSE or equivalent grades for each cluster subject
                            </span>
                            <div class="row mt-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 1</label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-4">{{ Str::limit( $course->subject1, $limit = 15 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject1" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value="@if($mycourse != null) {{ explode(' ', $subject->subject_1)[0] }} @endif" selected> {{ explode(' ', $subject->subject_1)[0] }}</option>
                                                @endif
                                            @foreach(explode('/', explode(' ', $course->subject1)[0]) as $option)
                                                <option value="{{ $option }}"> {{ $option }} </option>
                                            @endforeach

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade1" class="dept form-control form-control-md text-uppercase fs-sm" @if($mycourse != null && $mycourse->declaration == 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_1)[1]  }} @endif" selected> {{ explode(' ', $subject->subject_1)[1] }}</option>
                                                    @endif
                                                <option value="A"> A </option>
                                                <option value="A-"> A- </option>
                                                <option value="B+"> B+ </option>
                                                <option value="B"> B </option>
                                                <option value="B-"> B- </option>
                                                <option value="C+"> C+ </option>
                                                <option value="C"> C </option>
                                                <option value="C-"> C- </option>
                                                <option value="D+"> D+ </option>
                                                <option value="D"> D </option>
                                                <option value="D-"> D- </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 2</label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-4">{{ Str::limit( $course->subject2, $limit = 15 , $end='' )  }}</span>
                                        <select class="form-control form-control-sm text-uppercase" name="subject2" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_2)[0] }} @endif" selected> {{ explode(' ', $subject->subject_2)[0] }}</option>
                                                @endif
                                            @foreach(explode('/', explode(' ', $course->subject2)[0]) as $option)
                                                <option value="{{ $option }}"> {{ $option }} </option>
                                            @endforeach

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade2" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_2)[1] }} @endif" selected> {{ explode(' ', $subject->subject_2)[1] }}</option>
                                                    @endif
                                                <option value="A"> A </option>
                                                <option value="A-"> A- </option>
                                                <option value="B+"> B+ </option>
                                                <option value="B"> B </option>
                                                <option value="B-"> B- </option>
                                                <option value="C+"> C+ </option>
                                                <option value="C"> C </option>
                                                <option value="C-"> C- </option>
                                                <option value="D+"> D+ </option>
                                                <option value="D"> D </option>
                                                <option value="D-"> D- </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-password">Subject 3</label>
                                <div class="form-floating col-sm-10 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-4">{{ Str::limit( $course->subject3, $limit = 15 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject3" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_3)[0]}} @endif" selected> {{ explode(' ', $subject->subject_3)[0] }}</option>
                                                @endif
                                            @foreach(explode('/', explode(' ', $course->subject3)[0]) as $option)
                                                <option value="{{ $option }}"> {{ $option }} </option>
                                            @endforeach

                                        </select>


                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade3" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_3)[1] }} @endif" selected> {{ explode(' ', $subject->subject_3)[1] }}</option>
                                                    @endif
                                                <option value="A"> A </option>
                                                <option value="A-"> A- </option>
                                                <option value="B+"> B+ </option>
                                                <option value="B"> B </option>
                                                <option value="B-"> B- </option>
                                                <option value="C+"> C+ </option>
                                                <option value="C"> C </option>
                                                <option value="C-"> C- </option>
                                                <option value="D+"> D+ </option>
                                                <option value="D"> D </option>
                                                <option value="D-"> D- </option>
                                            </select>
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 4 </label>
                                <div class="col-sm-10 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-4">{{ Str::limit( $course->subject4, $limit = 15 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject4" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_4)[0] }} @endif" selected>{{ explode(' ', $subject->subject_4)[0] }}</option>
                                                @endif
                                            @foreach(explode('/', explode(' ', $course->subject4)[0]) as $option)
                                                <option value="{{ $option }}"> {{ $option }} </option>
                                            @endforeach

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade4" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $subject->subject_4)[1] }} @endif" selected> {{ explode(' ', $subject->subject_4)[1] }}</option>
                                                    @endif
                                                <option value="A"> A </option>
                                                <option value="A-"> A- </option>
                                                <option value="B+"> B+ </option>
                                                <option value="B"> B </option>
                                                <option value="B-"> B- </option>
                                                <option value="C+"> C+ </option>
                                                <option value="C"> C </option>
                                                <option value="C-"> C- </option>
                                                <option value="D+"> D+ </option>
                                                <option value="D"> D </option>
                                                <option value="D-"> D- </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-4 mt-4">
                                @if($mycourse != null)
                                    @if($mycourse != null && $mycourse->declaration== 1)
                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i> Course Details Updated </button>
                                    @else
                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i> Course Details Updated </button>
                                        <button class="btn btn-sm btn-alt-success" style="margin-left: 1rem; " data-toggle="click-ripple">
                                            Update Course
                                        </button>
                                    @endif
                                @else
                                <button class="btn btn-sm btn-alt-success" data-toggle="click-ripple">Save Course</button>
                                @endif
                            </div>
                            </form>
                        </div>
                        <div class="block-content tab-pane" id="btabs-vertical-work" role="tabpanel" aria-labelledby="btabs-vertical-work-tab">
                            <h4 class="fw-semibold">Work History</h4>
                            <table id="example1" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                                <thead>
                                <th>Organization Name</th>
                                <th>Post</th>
                                <th>Start Date</th>
                                <th>Exit Date</th>
                                </thead>
                                <tbody>
                                @foreach($work as $row)
                                    <tr>
                                        <td>{{ $row->organization }}</td>
                                        <td>{{ $row->post }}</td>
                                        <td>{{ $row->start_date }}</td>
                                        <td>{{ $row->exit_date }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="justify-content-sm-between my-4">
                                <button class="btn btn-sm btn-alt-info fs-sm" data-toggle="click-ripple" onclick="addwork()">Add new </button>
                            </div>

                            <div id="work" style="display: none;">
                                <div class="content">
                                    <form action="{{ route('application.addWork') }}" method="POST">
                                        @csrf
                                    <div class="col-md-12">
                                        <div class="form-floating py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('org1') }}" name="org1" placeholder="Organization name">
                                            <label class="form-label">ORGANIZATION NAME</label>
                                        </div>
                                        <div class="form-floating py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('org1post') }}" name="org1post" placeholder="Post held">
                                            <label class="form-label">POST HELD</label>
                                        </div>
                                        <div class="row py-1">
                                            <div class="form-floating col-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('org1startdate') }}" name="org1startdate">
                                                <small class="text-muted">Starting year</small>
                                            </div>
                                            <div class="form-floating col-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('org1enddate') }}" name="org1enddate">
                                                <small class="text-muted">Year Finished</small>
                                            </div>
                                        </div>
                                    </div>
                                <div class="d-flex justify-content-center my-4">
                                    <button class="btn btn-sm btn-alt-success">Submit work experience </button>
                                </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="block-content tab-pane @if(count($education) <= 0 && $mycourse != null) active @endif " id="btabs-vertical-education" role="tabpanel" aria-labelledby="btabs-vertical-education-tab">
                            <h4 class="fw-semibold">Education History</h4>
                            <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                                <thead>
                                    <th>Institution Name</th>
                                    <th>Level</th>
                                    <th>Qualifications</th>
                                    <th>Start Date</th>
                                    <th>Finish Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($education as $row)
                                        <tr>
                                            <td>{{ $row->institution }}</td>
                                            <td>{{ $row->level }}</td>
                                            <td>{{ $row->qualification }}</td>
                                            <td>{{ $row->start_date }}</td>
                                            <td>{{ $row->exit_date }}</td>
                                            <td><button type="button" class="btn btn-sm btn-alt-info" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-{{ $row->id }}">edit</button>

                                                <div class="modal" id="modal-block-vcenter-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="block block-rounded block-transparent mb-0">
                                                                <div class="block-header block-header-default">
                                                                    <h3 class="block-title">UPDATE YOUR SCHOOL HISTORY</h3>
                                                                    <div class="block-options">
                                                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="fa fa-fw fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content fs-sm">
                                                                    @if($row->level == 'SECONDARY')
                                                                        <form method="POST" action="{{ route('application.updateSecSch', Crypt::encrypt($row->id)) }}" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="row my-1">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <input type="text" class="form-control form-control-sm text-uppercase" value="{{ $row->institution }}" name="secondary" placeholder="Institution name">
                                                                                        <label class="form-label">SCHOOL NAME</label>
                                                                                    </div>
                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <input type="text" class="form-control form-control-sm text-uppercase" value="{{ $row->qualification }}" name="secondaryqualification" placeholder="Qualifications acquired">
                                                                                        <label class="form-label">QUALIFICATION</label>
                                                                                    </div>
                                                                                    <input type="hidden" value="SECONDARY" name="level">
                                                                                    <div class="row">
                                                                                        <div class="form-floating col-6">
                                                                                            <input type="month" class="form-control form-control-sm" value="{{ $row->start_date }}" name="secstartdate">
                                                                                            <small class="text-muted">Starting year</small>
                                                                                        </div>
                                                                                        <div class="form-floating col-6">
                                                                                            <input type="month" class="form-control form-control-sm" value="{{ $row->exit_date }}" name="secenddate">
                                                                                            <small class="text-muted">Year Finished</small>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <input type="file" class="form-control form-control-sm" value="{{ old('seccert') }}" name="seccert" placeholder="upload certificate">
                                                                                        <small class="text-muted">Upload certificate (format .pdf only )</small>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="subbutton">
                                                                                    <div class="d-flex justify-content-center my-4">
                                                                                        <button class="btn btn-alt-success col-sm-auto fs-sm" data-toggle="click-ripple">Save record</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        <form action="{{ route('application.updateTerSch', Crypt::encrypt($row->id)) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="row my-1">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <input type="text" class="form-control form-control-sm text-uppercase py-2" value="{{ $row->institution }}" name="tertiary" placeholder="INSTITUTION NAME">
                                                                                        <label class="form-label">INSTITUTION NAME</label>
                                                                                    </div>

                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <select name="level" class="form-control form-control-sm">
                                                                                            <option selected disabled value="{{ $row->level }}"> {{ $row->level }}</option>
                                                                                            <option value="CERTIFICATE">CERTIFICATE</option>
                                                                                            <option value="DIPLOMA">DIPLOMA</option>
                                                                                            <option value="DEGREE">DEGREE</option>
                                                                                            <option value="MASTERS">MASTERS</option>
                                                                                            <option value="PhD">PhD</option>
                                                                                        </select>
                                                                                        <label class="form-label">LEVEL OF STUDY</label>
                                                                                    </div>

                                                                                    <div class="form-floating col-sm-12 py-1">
                                                                                        <input type="text" class="form-control form-control-sm text-uppercase" value="{{ $row->qualification }}" name="teriaryqualification" placeholder="Qualifications acquired">
                                                                                        <label class="form-label">QUALIFICATION</label>
                                                                                    </div>

                                                                                    <div class="row py-1">
                                                                                        <div class="form-floating col-sm-6">
                                                                                            <input type="month" class="form-control form-control-sm" value="{{  $row->start_date }}" name="terstartdate">
                                                                                            <small class="text-muted py-1">Starting year</small>
                                                                                        </div>
                                                                                        <div class="form-floating col-sm-6">
                                                                                            <input type="month" class="form-control form-control-sm" value="{{ $row->exit_date }}" name="terenddate">
                                                                                            <small class="text-muted py-1">Year Finished</small>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-floating col-sm-12">
                                                                                        <input type="file" class="form-control form-control-sm" value="{{ old('tercert')}}" name="tercert">
                                                                                        <small class="text-muted py-1">Upload Certificate ( format .pdf only)</small>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="d-flex justify-content-center my-4">
                                                                                    <button class="btn btn-alt-success col-sm-auto fs-sm" data-toggle="click-ripple">Save record</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>


                                                                    @endif
                                                                </div>
                                                                <div class="block-content block-content-full text-end bg-body">
                                                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Perfect</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="justify-content-sm-between my-4">
                                <button class="btn btn-sm btn-alt-info fs-sm" data-toggle="click-ripple" onclick="showoptios()">Add new </button>
                            </div>

                            <div class="my-4" id="institution" style="display: none; ">
                                <div class="space-x-1">
                                    <sup class="fs-sm text-danger text-lowercase mt-2">*</sup>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="institution" value="secondary" required>
                                        <label class="form-check-label">Secondary School</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="institution" value="tertiary" required>
                                        <label class="form-check-label">Tertiary Institution</label>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('application.secSch') }}" enctype="multipart/form-data">
                                    @csrf
                                <div class="row secondary my-4">
                                    <div class="col-md-2">
                                        <label class="form-check-label"> Secondary school</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating col-sm-12 py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('secondary') }}" name="secondary" placeholder="Institution name">
                                            <label class="form-label">SCHOOL NAME</label>
                                        </div>
                                        <div class="form-floating col-sm-12 py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('secondaryqualification') }}" name="secondaryqualification" placeholder="Qualifications acquired">
                                            <label class="form-label">QUALIFICATION</label>
                                        </div>
                                        <input type="hidden" value="SECONDARY" name="level">
                                        <div class="row">
                                            <div class="form-floating col-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('secstartdate') }}" name="secstartdate">
                                                <small class="text-muted">Starting year</small>
                                            </div>
                                            <div class="form-floating col-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('secenddate') }}" name="secenddate">
                                                <small class="text-muted">Year Finished</small>
                                            </div>
                                        </div>
                                        <div class="form-floating col-sm-12 py-1">
                                            <input type="file" class="form-control form-control-sm" value="{{ old('seccert') }}" name="seccert" placeholder="upload certificate">
                                            <small class="text-muted">Upload certificate (format .pdf only )</small>
                                        </div>
                                    </div>
                                    <div class="subbutton">
                                        <div class="d-flex justify-content-center my-4">
                                            <button class="btn btn-alt-success col-sm-auto fs-sm" data-toggle="click-ripple">Save record</button>
                                        </div>
                                    </div>
                                </div>
                                </form>

                                <form action="{{ route('application.terSch') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row tertiary my-4">
                                    <div class="col-md-2">
                                        <label class="form-check-label"> Tertiary Institution</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating col-sm-12 py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase py-2" value="{{ old('tertiary') }}" name="tertiary" placeholder="INSTITUTION NAME">
                                            <label class="form-label">INSTITUTION NAME</label>
                                        </div>

                                        <div class="form-floating col-sm-12 py-1">
                                            <select name="level" class="form-control form-control-sm">
                                                <option selected disabled> select level of study</option>
                                                <option value="CERTIFICATE">CERTIFICATE</option>
                                                <option value="DIPLOMA">DIPLOMA</option>
                                                <option value="DEGREE">DEGREE</option>
                                                <option value="MASTERS">MASTERS</option>
                                                <option value="PhD">PhD</option>
                                            </select>
                                            <label class="form-label">LEVEL OF STUDY</label>
                                        </div>

                                        <div class="form-floating col-sm-12 py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('teriaryqualification') }}" name="teriaryqualification" placeholder="Qualifications acquired">
                                            <label class="form-label">QUALIFICATION</label>
                                        </div>

                                        <div class="row py-1">
                                            <div class="form-floating col-sm-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('terstartdate') }}" name="terstartdate">
                                                <small class="text-muted py-1">Starting year</small>
                                            </div>
                                            <div class="form-floating col-sm-6">
                                                <input type="month" class="form-control form-control-sm" value="{{ old('terenddate') }}" name="terenddate">
                                                <small class="text-muted py-1">Year Finished</small>
                                            </div>
                                        </div>
                                        <div class="form-floating col-sm-12">
                                            <input type="file" class="form-control form-control-sm" value="{{ old('tercert')}}" name="tercert">
                                            <small class="text-muted py-1">Upload Certificate ( format .pdf only)</small>
                                        </div>

                                    </div>
                                        <div class="d-flex justify-content-center my-4">
                                            <button class="btn btn-alt-success col-sm-auto fs-sm" data-toggle="click-ripple">Save record</button>
                                        </div>
                                </div>
                            </form>

                            </div>
                        </div>
                        <div class="block-content tab-pane @if($mycourse != null && $mycourse->receipt == null && count($education) >= 1 && $mycourse->declaration == 1) active @endif" id="btabs-vertical-fee" role="tabpanel" aria-labelledby="btabs-vertical-fee-tab">
                            <h4 class="fw-semibold">Application Fees</h4>
                            <form action="{{ route('application.payment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-muted">To complete application you must pay and add payment details to this form</p>
                                    <p> You are required to pay <span class="fw-bold"> Ksh. {{ $course->application_fee }} </span> to complete this application.</p>
                                    @if($mycourse != null)
                                    <p>To complete application payment use <b>{{ $mycourse->application_number }}</b> as account number for any of the preferred payment method</p>
                                    @else
                                    @endif

                                </div>
                                <div class="col-md-8">
                                    <div class="block-content fs-sm">
                                        Fee is payable through the following bank and branches:
                                        <ul>
                                            <li>Cooperative Bank of Kenya <b>Acc. No 01129079001600 </b> (Nkrumah Rd Branch).</li>
                                            <li>Standard Chartered Bank <b>Acc. No. 0102092728000 </b>(Treasury Square).</li>
                                            <li>Equity Bank <b> Acc. No. 0460297818058 </b> (Digo Rd Branch).</li>
                                            <li>National Bank <b> Acc. No. 01038074211700 </b> (TUM Branch).</li>
                                            <li>KCB Lamu Campus: <b> Acc. No. 1118817192 </b> (Mvita Branch).</li>
                                            <li>KCB (TUM) Fee Collection <b> Acc No. 1169329578 </b> (Mvita Branch).</li>
                                            <li>Barclays Bank <b> Acc. No. 2034098894 </b> (Nkrumah Rd Branch).</li>
                                            or
                                            <li>Via MPesa <b>pay bill number 4045313 </b></li>
                                        </ul>

                                        <span class="text-muted text-center" style="color: red !important;">Application fee is non refundable</span>
                                    </div>
{{--                                    <div class="py-2 mb-0">--}}

{{--                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> How do I pay?</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-floating text-uppercase py-1">--}}
{{--                                        <input type="text" class="form-control form-control-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif required value="{{ old('receipt') }} @if($mycourse != null && $mycourse->receipt != null) {{ $mycourse->receipt }} @endif" name="receipt" placeholder="Enter RECEIPT NUMBER">--}}
{{--                                        <label class="form-label">TRANSACTION CODE</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-floating text-uppercase py-1">--}}
{{--                                        <input type="file" class="form-control form-control-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif required value="{{ old('receipt_file') }} " name="receipt_file">--}}
{{--                                    </div>--}}
{{--                                        <input type="hidden" value="{{ $course->id }}" name="course_id">--}}
{{--                                    <small class="text-muted">upload your bank reciept (format .pdf only )</small>--}}
{{--                                    <div class="d-flex justify-content-center my-4">--}}
{{--                                        @if($mycourse != null && $mycourse->receipt != null)--}}
{{--                                            @if($mycourse != null && $mycourse->declaration== 1)--}}
{{--                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i>--}}
{{--                                            Payments Details Updated--}}
{{--                                        </button>--}}
{{--                                            @else--}}
{{--                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i>  Payments Details Updated</button>--}}
{{--                                        <button class="btn btn-sm btn-alt-success" style="margin-left: 1rem;" data-toggle="click-ripple">Update payments</button>--}}
{{--                                            @endif--}}
{{--                                        @else--}}
{{--                                        <button class="btn btn-sm btn-alt-success" data-toggle="click-ripple">Submit payments</button>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
                                </div>
                        </div>
                            </form>
                        </div>
                        <div class="block-content tab-pane" id="btabs-vertical-sponsor" role="tabpanel" aria-labelledby="btabs-vertical-sponsor-tab">
                            <h4 class="fw-semibold">Guardian & Sponsor Details</h4>
                            <p class="fs-sm">
                            <div class="content">
                                <h5 class="fw-semibold">Parent / Next of kin</h5>
                                <form method="POST" action="{{ route('application.addParent') }}">
                                    @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="text-muted">Add the details of your parent or guardian here</p>
                                    </div>
                                    <div class="col-md-8 my-4">
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('parentname') }}" name="parentname" placeholder="Parent/Guardian name">
                                            <label class="form-label">PARENT NAME</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('parentmobile') }}" name="parentmobile" placeholder="Parent/Guardian mobile number">
                                            <label class="form-label">PARENT PHONE NUMBER</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('parentcounty') }}" name="parentcounty" placeholder="Parent/Guardian county of residence">
                                            <label class="form-label">PARENTS HOME COUNTY</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('parenttown') }}" name="parenttown" placeholder="Parent/Guardian Home town">
                                            <label class="form-label">PARENT HOME TOWN</label>
                                        </div>
                                    </div>
                                </div>
                           <h5 class="fw-semibold">Sponsor</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="text-muted">Add the details of the person or organization that will be paying your school fees</p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm" value="{{ old('sponsorname') }}" name="sponsorname" placeholder="Sponsor name">
                                            <label class="form-label">SPONSOR NAME</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm" value="{{ old('sponsormobile') }}" name="sponsormobile" placeholder="Sponsor mobile number">
                                            <label class="form-label">SPONSOR PHONE NUMBER</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('sponsorcounty') }}" name="sponsorcounty" placeholder="Sponsor county of residence">
                                            <label class="form-label">SPONSOR HOME COUNTY</label>
                                        </div>
                                        <div class="form-floating text-uppercase py-1">
                                            <input type="text" class="form-control form-control-sm text-uppercase" value="{{ old('sponsortown') }}" name="sponsortown" placeholder="Sponsor Home town">
                                            <label class="form-label">SPONSOR HOME TOWN</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center my-4">
                                        <button class="btn btn-sm btn-alt-success" data-toggle="click-ripple">Submit </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-content tab-pane @if($mycourse != null && $mycourse->applicationApproval == null && count($education) > 0) active @endif " id="btabs-vertical-submit" role="tabpanel" aria-labelledby="btabs-vertical-submit-tab">
                            <h4 class="fw-semibold">Finish application</h4>
                            <p class="fs-sm">
                            <div class="block-content-full">
                                    <div class="p-sm-2 p-xl-12">
                                        <div class="row mb-2 text-center">
                                            <span class="fw-semibold mb-2"> {{ $course->name }} </span>
                                            <span class="fw-semibold mb-2"> {{ $course->name }}</span>
                                            <span class="fw-semibold mb-2"> {{ $course->course_name }} </span>
                                        </div>

                                        <table class="table table-sm table-bordered table-striped table-responsive-md">
                                            @if($mycourse != null)
                                                <thead>
                                                <th>Receipt Number</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @if($mycourse->applicationApproval != null)
                                                        {{ $mycourse->applicationApproval->invoice_number}}
                                                        @else
                                                            Visit <b>Application Fee </b> menu to pay
                                                        @endif
                                                    </td>
                                                    <td>{{ $course->fee }}</td>
                                                    <td>
                                                        @if($mycourse->applicationApproval != null && $mycourse->applicationApproval->finance_status == 1)
                                                         <span class="badge bg-success"> <i class="fa fa-check-circle"> Paid </i> </span>
                                                        @else
                                                            <span class="badge bg-warning"> <i class="fa fa-spinner"> Pending </i> </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                </tbody>
                                            @endif
                                                @if($mycourse != null)
                                                    <thead>
                                                        <th colspan="1">Course Requirements</th>
                                                        <th colspan="2"> {{ $course->course_requirements }} </th>
                                                    </thead>

                                                    <thead>
                                                    <th colspan="1">Application Reference Number</th>
                                                    <th colspan="2"> {{ $mycourse->ref_number }} </th>
                                                    </thead>
                                                @endif
                                            @if($mycourse != null)
                                                        <thead>
                                                        <th>Cluster subject</th>
                                                        <th>Your Score</th>
                                                        <th>Qualified?</th>
                                                        </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $course->subject1 }}</td>
                                                            <td>{{ $subject->subject_1 }}</td>
                                                            <td>
                                                                @php

                                                                    if(explode(' ', $course->subject1)[1] == 'A'){
                                                                        $grade1 = 12;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'A-'){
                                                                        $grade1 = 11;

                                                                    }elseif(explode(' ', $course->subject1)[1] == 'B+'){
                                                                        $grade1 = 10;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'B'){
                                                                        $grade1 = 9;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'B-'){
                                                                        $grade1 = 8;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'C+'){
                                                                        $grade1 = 7;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'C'){
                                                                        $grade1 = 6;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'C-'){
                                                                        $grade1 = 5;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'D+'){
                                                                        $grade1 = 4;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'D'){
                                                                        $grade1 = 3;
                                                                    }elseif(explode(' ', $course->subject1)[1] == 'D-'){
                                                                        $grade1 = 2;
                                                                    }else{
                                                                        $grade1 = 1;
                                                                    }

                                                                  if(explode(' ', $subject->subject_1)[1] == 'A'){
                                                                        $score1 = 12;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'A-'){
                                                                        $score1 = 11;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'B+'){
                                                                        $score1 = 10;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'B'){
                                                                        $score1 = 9;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'B-'){
                                                                        $score1 = 8;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'C+'){
                                                                        $score1 = 7;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'C'){
                                                                        $score1 = 6;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'C-'){
                                                                        $score1 = 5;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'D+'){
                                                                        $score1 = 4;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'D'){
                                                                        $score1 = 3;
                                                                    }elseif(explode(' ', $subject->subject_1)[1] == 'D-'){
                                                                        $score1 = 2;
                                                                    }else{
                                                                        $score1 = 1;
                                                                    }
                                                                @endphp

                                                                @if($score1 >= $grade1)
                                                                    <i class="fa fa-check text-success"></i>
                                                                @else
                                                                    <i class="fa fa-ban text-danger"></i>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->subject2 }}</td>
                                                            <td>{{ $subject->subject_2 }}</td>
                                                            <td>
                                                                @php

                                                                    if(explode(' ', $course->subject2)[1] == 'A'){
                                                                        $grade2 = 12;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'A-'){
                                                                        $grade2 = 11;

                                                                    }elseif(explode(' ', $course->subject2)[1] == 'B+'){
                                                                        $grade2 = 10;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'B'){
                                                                        $grade2 = 9;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'B-'){
                                                                        $grade2 = 8;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'C+'){
                                                                        $grade2 = 7;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'C'){
                                                                        $grade2 = 6;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'C-'){
                                                                        $grade2 = 5;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'D+'){
                                                                        $grade2 = 4;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'D'){
                                                                        $grade2 = 3;
                                                                    }elseif(explode(' ', $course->subject2)[1] == 'D-'){
                                                                        $grade2 = 2;
                                                                    }else{
                                                                        $grade2 = 1;
                                                                    }

                                                                  if(explode(' ', $subject->subject_2)[1] == 'A'){
                                                                        $score2 = 12;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'A-'){
                                                                        $score2 = 11;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'B+'){
                                                                        $score2 = 10;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'B'){
                                                                        $score2 = 9;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'B-'){
                                                                        $score2 = 8;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'C+'){
                                                                        $score2 = 7;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'C'){
                                                                        $score2 = 6;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'C-'){
                                                                        $score2 = 5;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'D+'){
                                                                        $score2 = 4;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'D'){
                                                                        $score2 = 3;
                                                                    }elseif(explode(' ', $subject->subject_2)[1] == 'D-'){
                                                                        $score2 = 2;
                                                                    }else{
                                                                        $score2 = 1;
                                                                    }
                                                                @endphp

                                                                @if($score2 >= $grade2)
                                                                    <i class="fa fa-check text-success"></i>
                                                                @else
                                                                    <i class="fa fa-ban text-danger"></i>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->subject3 }}</td>
                                                            <td>{{ $subject->subject_3 }}</td>
                                                            <td>
                                                                @php

                                                                    if(explode(' ', $course->subject3)[1] == 'A'){
                                                                        $grade3 = 12;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'A-'){
                                                                        $grade3 = 11;

                                                                    }elseif(explode(' ', $course->subject3)[1] == 'B+'){
                                                                        $grade3 = 10;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'B'){
                                                                        $grade3 = 9;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'B-'){
                                                                        $grade3 = 8;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'C+'){
                                                                        $grade3 = 7;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'C'){
                                                                        $grade3 = 6;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'C-'){
                                                                        $grade3 = 5;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'D+'){
                                                                        $grade3 = 4;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'D'){
                                                                        $grade3 = 3;
                                                                    }elseif(explode(' ', $course->subject3)[1] == 'D-'){
                                                                        $grade3 = 2;
                                                                    }else{
                                                                        $grade3 = 1;
                                                                    }

                                                                  if(explode(' ', $subject->subject_3)[1] == 'A'){
                                                                        $score3 = 12;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'A-'){
                                                                        $score3 = 11;

                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'B+'){
                                                                        $score3 = 10;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'B'){
                                                                        $score3 = 9;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'B-'){
                                                                        $score3 = 8;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'C+'){
                                                                        $score3 = 7;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'C'){
                                                                        $score3 = 6;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'C-'){
                                                                        $score3 = 5;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'D+'){
                                                                        $score3 = 4;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'D'){
                                                                        $score3 = 3;
                                                                    }elseif(explode(' ', $subject->subject_3)[1] == 'D-'){
                                                                        $score3 = 2;
                                                                    }else{
                                                                        $score3 = 1;
                                                                    }
                                                                @endphp

                                                                @if($score3 >= $grade3)
                                                                    <i class="fa fa-check text-success"></i>
                                                                @else
                                                                    <i class="fa fa-ban text-danger"></i>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->subject4 }}</td>
                                                            <td>{{ $subject->subject_4 }}</td>
                                                            <td>
                                                                @php

                                                                  if(explode(' ', $course->subject4)[1] == 'A'){
                                                                      $grade4 = 12;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'A-'){
                                                                      $grade4 = 11;

                                                                  }elseif(explode(' ', $course->subject4)[1] == 'B+'){
                                                                      $grade4 = 10;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'B'){
                                                                      $grade4 = 9;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'B-'){
                                                                      $grade4 = 8;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'C+'){
                                                                      $grade4 = 7;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'C'){
                                                                      $grade4 = 6;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'C-'){
                                                                      $grade4 = 5;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'D+'){
                                                                      $grade4 = 4;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'D'){
                                                                      $grade4 = 3;
                                                                  }elseif(explode(' ', $course->subject4)[1] == 'D-'){
                                                                      $grade4 = 2;
                                                                  }else{
                                                                      $grade4 = 1;
                                                                  }

                                                                if(explode(' ', $subject->subject_4)[1] == 'A'){
                                                                      $score4 = 12;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'A-'){
                                                                      $score4 = 11;

                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'B+'){
                                                                      $score4 = 10;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'B'){
                                                                      $score4 = 9;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'B-'){
                                                                      $score4 = 8;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'C+'){
                                                                      $score4 = 7;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'C'){
                                                                      $score4 = 6;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'C-'){
                                                                      $score4 = 5;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'D+'){
                                                                      $score4 = 4;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'D'){
                                                                      $score4 = 3;
                                                                  }elseif(explode(' ', $subject->subject_4)[1] == 'D-'){
                                                                      $score4 = 2;
                                                                  }else{
                                                                      $score4 = 1;
                                                                  }
                                                                @endphp
                                                                @if($score4 >= $grade4)
                                                                    <i class="fa fa-check text-success"></i>
                                                                @else
                                                                    <i class="fa fa-ban text-danger"></i>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            @if($score1 >= $grade1 && $score2 >= $grade2 && $score3 >= $grade3 && $score4 >= $grade4)
                                                                <p class="text-success text-center fs-sm m-2">
                                                                    Congratulations!! You meet the minimum course subject requirements to pursue {{ $course->course_name }} Course. Please proceed to submit your application for approval.
                                                                </p>
                                                            @else
                                                                <p class="text-warning text-center fs-sm m-2">
                                                                    Oops! You do not meet the minimum course subject requirements to pursue {{ $course->course_name }} Course. Please try looking for a course that you meet the minimum course subject requirements. Submiting this application will not guarantee you selection.
                                                                </p>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                @endif

                                        </table>

                            <div class="row">
                                @if($mycourse != null)
                                <form action="{{ route('application.finish') }}" method="POST">
                                    @csrf
                                    @if(count($education) > 0)
                                <div class="col-md-12">
                                    <span>Applicant Declaration</span>
                                    <div class="" style="padding: 7px !important;">
                                        <input type="checkbox" name="declare" required @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                        <input hidden name="course_id" value="@if($mycourse != null) {{ $mycourse->course_id }} @endif">
                                        <input hidden name="intake_id" value="@if($mycourse != null) {{ $mycourse->intake_id }} @endif">
                                        I <span class="text-decoration-underline"> {{ auth()->guard('web')->user()->infoApplicant->sname }} {{ auth()->guard('web')->user()->infoApplicant->mname }} {{ auth()->guard('web')->user()->infoApplicant->fname }}</span> declare that the information given in this application form is correct. I further certify that I have read, understood and agreed to comply with the terms stipulated herein.
                                    </div>
                                </div>
                                    <div class="d-flex justify-content-center mb-1 mt-4">
                                        @if($mycourse != null && $mycourse->declaration == 1)
                                            <button class="btn btn-success" disabled> <i class="fa fa-check-circle"></i> Submitted </button>
                                        @else
                                        <button onclick='confirm("Once this application has been submitted cannot be changed. Are you sure you want to submit the application?")' class="btn btn-sm btn-alt-success">Submit Application</button>
                                        @endif
                                    </div>
                                    @endif
                                </form>
                                @endif
                            </div>
                      </p>
                        </div>
                    </div>
                </div>
                <!-- END Vertical Block Tabs Default Style -->
            </div>
        </div>
    </div>
@endsection



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
                            <button class="nav-link text-md-start active" id="btabs-vertical-course-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-course" role="tab" aria-controls="btabs-vertical-course" aria-selected="true">
                                <i class="fa fa-fw fa-book-atlas opacity-50 me-1 d-none d-sm-inline-block"></i> Course Details
                                @if($mycourse != null)
                                <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item d-md-flex flex-md-column">
                            <button class="nav-link text-md-start" id="btabs-vertical-education-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-education" role="tab" aria-controls="btabs-vertical-education" aria-selected="false">
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
                                @if($mycourse != null && $mycourse->receipt != null)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Complete </span>
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
                            <button class="nav-link text-md-start" id="btabs-vertical-submit-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical-submit" role="tab" aria-controls="btabs-vertical-submit" aria-selected="false">
                                <i class="fa fa-fw fa-check-double opacity-50 me-1 d-none d-sm-inline-block"></i> Complete Application
                                @if($mycourse != null && $mycourse->receipt != null && count($education) > 0)
                                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Submit </span>
                                @endif
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content col-md-9">
                        <div class="block-content tab-pane active" id="btabs-vertical-course" role="tabpanel" aria-labelledby="btabs-vertical-home-course">
                            <h4 class="fw-semibold">Course Details</h4>
                            <form method="POST" action="{{ route('application.submitApp') }}">
                                @csrf
                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-password">Course</label>
                                <div class="form-floating col-sm-8 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-sm" name="course" value="{{ $course->mainCourses->course_name }}" readonly>
                                </div>
                            </div>
                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Department</label>
                                <div class="form-floating col-sm-8 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-sm" name="department" value="{{ $course->mainCourses->getCourseDept->name }}" readonly>
                                    <input type="hidden" name="dept" value="{{ $course->mainCourses->getCourseDept->id }}">
                                    <input type="hidden" name="school" value="{{ $course->mainCourses->getCourseDept->schools->id }}">
                                </div>
                            </div>
                            <div class="row my-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">School</label>
                                <div class="form-floating col-sm-8 text-uppercase py-1">
                                    <input type="text" class="form-control form-control-sm" name="" value="{{ $course->mainCourses->getCourseDept->schools->name }}" readonly>
                                    <input type="hidden" name="intake" value="{{ $course->openCourse->id }}">
                                    <input type="hidden" name="course_id" value="{{ $course->mainCourses->id }}">
                                </div>
                            </div>
                            <div class="row" style="padding: 5px !important;">
                                <label class="col-sm-2 col-form-label" for="example-hf-password">Campus</label>
                                <div class="col-sm-8 text-uppercase mb-4" style="padding: 5px !important;">
                                    <div class="space-x-1">
                                        <sup class="fs-sm text-danger text-lowercase mt-2">*</sup>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="campus" value="Main"
                                                   @if($mycourse != null) {{ ($mycourse->campus == 'Main')? "checked" : "" }}@endif
                                                   @if(old('campus')== 'Main') checked @endif required @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <label class="form-check-label">Main</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="campus" value="Kwale"
                                                   @if($mycourse != null) {{ ($mycourse->campus == 'Kwale')? "checked" : "" }}@endif
                                                   @if(old('campus')== 'Kwale')  checked @endif required @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <label class="form-check-label">Kwale</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="campus" value="Lamu"
                                                   @if($mycourse != null) {{ ($mycourse->campus == 'Lamu')? "checked" : "" }}@endif
                                                   @if(old('campus')== 'Lamu') checked @endif required @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <label class="form-check-label">Lamu</label>
                                        </div>
                                        <span class="fs-sm text-danger text-lowercase mt-2"> choose which campus to join </span>
                                    </div>
                                </div>
                            </div>
                            <span class="h5 fw-semibold">Cluster Subject</span>
                            <span class="fs-sm">
                                <sup class="fs-sm text-danger text-lowercase mt-2">*</sup>
                                provide your KCSE or equivalent grades for each cluster subject
                            </span>
                            <div class="row mt-2">
                                <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 1</label>
                                <div class="col-sm-8 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-3">{{ Str::limit( $course->mainCourses->courseRequirements->subject1, $limit = 10 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject1" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value="@if($mycourse != null) {{ explode(' ', $mycourse->subject_1)[0] }} @endif" selected> {{ explode(' ', $mycourse->subject_1)[0] }}</option>
                                                @endif
                                            <option value="ENG"> ENG </option>
                                            <option value="KIS"> KIS </option>
                                            <option value="MAT"> MAT </option>
                                            <option value="BIO"> BIO </option>
                                            <option value="CHE"> CHE </option>
                                            <option value="PHY"> PHY </option>
                                            <option value="GEO"> GEO </option>
                                            <option value="CRE"> CRE </option>
                                            <option value="FRE"> FRE </option>
                                            <option value="GER"> GER </option>
                                            <option value="HIS"> HIS </option>
                                            <option value="COM"> COM </option>
                                            <option value="AGR"> AGR </option>
                                            <option value="BUS"> BUS </option>
                                            <option value="IRE"> IRE </option>
                                            <option value="HRE"> HRE </option>
                                            <option value="HSCI"> HSCI </option>
                                            <option value="MUS"> MUSIC </option>
                                            <option value="ARA"> ARABIC </option>
                                            <option value="WW"> WOODWORK </option>
                                            <option value="MW"> METALWORK </option>
                                            <option value="SIGN"> SIGN LANG </option>

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade1" class="dept form-control form-control-md text-uppercase fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_1)[1]  }} @endif" selected> {{ explode(' ', $mycourse->subject_1)[1] }}</option>
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
                                <div class="col-sm-8 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-3">{{ Str::limit( $course->mainCourses->courseRequirements->subject2, $limit = 10 , $end='' )  }}</span>
                                        <select class="form-control form-control-sm text-uppercase" name="subject2" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_2)[0] }} @endif" selected> {{ explode(' ', $mycourse->subject_2)[0] }}</option>
                                                @endif
                                            <option value="ENG"> ENG </option>
                                            <option value="KIS"> KIS </option>
                                            <option value="MAT"> MAT </option>
                                            <option value="BIO"> BIO </option>
                                            <option value="CHE"> CHE </option>
                                            <option value="PHY"> PHY </option>
                                            <option value="GEO"> GEO </option>
                                            <option value="CRE"> CRE </option>
                                            <option value="FRE"> FRE </option>
                                            <option value="GER"> GER </option>
                                            <option value="HIS"> HIS </option>
                                            <option value="COM"> COM </option>
                                            <option value="AGR"> AGR </option>
                                            <option value="BUS"> BUS </option>
                                            <option value="IRE"> IRE </option>
                                            <option value="HRE"> HRE </option>
                                            <option value="HSCI"> HSCI </option>
                                            <option value="MUS"> MUSIC </option>
                                            <option value="ARA"> ARABIC </option>
                                            <option value="WW"> WOODWORK </option>
                                            <option value="MW"> METALWORK </option>
                                            <option value="SIGN"> SIGN LANG </option>

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade2" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_2)[1] }} @endif" selected> {{ explode(' ', $mycourse->subject_2)[1] }}</option>
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
                                <div class="form-floating col-sm-8 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-3">{{ Str::limit( $course->mainCourses->courseRequirements->subject3, $limit = 10 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject3" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_3)[0]}} @endif" selected> {{ explode(' ', $mycourse->subject_3)[0] }}</option>
                                                @endif
                                            <option value="ENG"> ENG </option>
                                            <option value="KIS"> KIS </option>
                                            <option value="MAT"> MAT </option>
                                            <option value="BIO"> BIO </option>
                                            <option value="CHE"> CHE </option>
                                            <option value="PHY"> PHY </option>
                                            <option value="GEO"> GEO </option>
                                            <option value="CRE"> CRE </option>
                                            <option value="FRE"> FRE </option>
                                            <option value="GER"> GER </option>
                                            <option value="HIS"> HIS </option>
                                            <option value="COM"> COM </option>
                                            <option value="AGR"> AGR </option>
                                            <option value="BUS"> BUS </option>
                                            <option value="IRE"> IRE </option>
                                            <option value="HRE"> HRE </option>
                                            <option value="HSCI"> HSCI </option>
                                            <option value="MUS"> MUSIC </option>
                                            <option value="ARA"> ARABIC </option>
                                            <option value="WW"> WOODWORK </option>
                                            <option value="MW"> METALWORK </option>
                                            <option value="SIGN"> SIGN LANG </option>

                                        </select>


                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade3" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_3)[1] }} @endif" selected> {{ explode(' ', $mycourse->subject_3)[1] }}</option>
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
                                <div class="col-sm-8 text-uppercase py-1">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text input-group-text-sm col-md-3">{{ Str::limit( $course->mainCourses->courseRequirements->subject4, $limit = 10 , $end='' )  }}</span>

                                        <select class="form-control form-control-sm text-uppercase" name="subject4" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                            <option disabled selected> -- select subject-- </option>
                                                @if($mycourse != null)
                                                    <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_4)[0] }} @endif" selected>{{ explode(' ', $mycourse->subject_4)[0] }}</option>
                                                @endif
                                            <option value="ENG" > ENG </option>
                                            <option value="KIS"> KIS </option>
                                            <option value="MAT"> MAT </option>
                                            <option value="BIO"> BIO </option>
                                            <option value="CHE"> CHE </option>
                                            <option value="PHY"> PHY </option>
                                            <option value="GEO"> GEO </option>
                                            <option value="CRE"> CRE </option>
                                            <option value="FRE"> FRE </option>
                                            <option value="GER"> GER </option>
                                            <option value="HIS"> HIS </option>
                                            <option value="COM"> COM </option>
                                            <option value="AGR"> AGR </option>
                                            <option value="BUS"> BUS </option>
                                            <option value="IRE"> IRE </option>
                                            <option value="HRE"> HRE </option>
                                            <option value="HSCI"> HSCI </option>
                                            <option value="MUS"> MUSIC </option>
                                            <option value="ARA"> ARABIC </option>
                                            <option value="WW"> WOODWORK </option>
                                            <option value="MW"> METALWORK </option>
                                            <option value="SIGN"> SIGN LANG </option>

                                        </select>

                                        <span class="input-group-text input-group-text-sm">
                                            <select name="grade4" class="dept form-control form-control-md text-uppercase m-1 fs-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                                <option selected disabled > -- select grade -- </option>
                                                    @if($mycourse != null)
                                                        <option value=" @if($mycourse != null) {{ explode(' ', $mycourse->subject_4)[1] }} @endif" selected> {{ explode(' ', $mycourse->subject_4)[1] }}</option>
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
                        <div class="block-content tab-pane" id="btabs-vertical-education" role="tabpanel" aria-labelledby="btabs-vertical-education-tab">
                            <h4 class="fw-semibold">Education History</h4>
                            <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                                <thead>
                                    <th>Institution Name</th>
                                    <th>Level</th>
                                    <th>Qualifications</th>
                                    <th>Start Date</th>
                                    <th>Finish Date</th>
                                </thead>
                                <tbody>
                                    @foreach($education as $row)
                                        <tr>
                                            <td>{{ $row->institution }}</td>
                                            <td>{{ $row->level }}</td>
                                            <td>{{ $row->qualification }}</td>
                                            <td>{{ $row->start_date }}</td>
                                            <td>{{ $row->exit_date }}</td>
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
                                        <input type="hidden" value="secondary" name="level">
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
                                            <small class="text-muted">Upload certificate (format .pdf .pgn .jpeg .jpg)</small>
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
                                            <small class="text-muted py-1">Upload Certificate ( format.pdf .png .jpeg .jpg)</small>
                                        </div>

                                    </div>
                                        <div class="d-flex justify-content-center my-4">
                                            <button class="btn btn-alt-success col-sm-auto fs-sm" data-toggle="click-ripple">Save record</button>
                                        </div>
                                </div>
                            </form>

                            </div>
                        </div>
                        <div class="block-content tab-pane" id="btabs-vertical-fee" role="tabpanel" aria-labelledby="btabs-vertical-fee-tab">
                            <h4 class="fw-semibold">Application Fees</h4>
                            <form action="{{ route('application.payment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-muted">To complete application you must pay and add payment details to this form</p>
                                </div>
                                <div class="col-md-8">
                                    <div class="py-2 mb-0">
                                        You are required to pay <span class="fw-bold">Ksh. {{ $course->mainCourses->courseRequirements->fee }} </span> to complete this application.
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> How do I pay?</a>
                                    </div>
                                    <div class="form-floating text-uppercase py-1">
                                        <input type="text" class="form-control form-control-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif required value="{{ old('receipt') }} @if($mycourse != null && $mycourse->receipt != null) {{ $mycourse->receipt }} @endif" name="receipt" placeholder="Enter RECEIPT NUMBER">
                                        <label class="form-label">TRANSACTION CODE</label>
                                    </div>
                                    <div class="form-floating text-uppercase py-1">
                                        <input type="file" class="form-control form-control-sm" @if($mycourse != null && $mycourse->declaration== 1) disabled @endif required value="{{ old('receipt_file') }} " name="receipt_file">
                                    </div>
                                        <input type="hidden" value="{{ $course->mainCourses->id }}" name="course_id">
                                    <small class="text-muted">upload your bank reciept (format .pdf .png .jpeg .jpg</small>
                                    <div class="d-flex justify-content-center my-4">
                                        @if($mycourse != null && $mycourse->receipt != null)
                                            @if($mycourse != null && $mycourse->declaration== 1)
                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i>
                                            Payments Details Updated
                                        </button>
                                            @else
                                        <button class="btn btn-sm btn-success" disabled data-toggle="click-ripple"><i class="fa fa-check-circle"></i>  Payments Details Updated</button>
                                        <button class="btn btn-sm btn-alt-success" style="margin-left: 1rem;" data-toggle="click-ripple">Update payments</button>
                                            @endif
                                        @else
                                        <button class="btn btn-sm btn-alt-success" data-toggle="click-ripple">Submit payments</button>
                                        @endif
                                    </div>
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
                        <div class="block-content tab-pane" id="btabs-vertical-submit" role="tabpanel" aria-labelledby="btabs-vertical-submit-tab">
                            <h4 class="fw-semibold">Finish application</h4>
                            <p class="fs-sm">
                            <div class="block-content-full">
                                    <div class="p-sm-2 p-xl-12">
                                        <div class="row mb-2 text-center">
                                            <span class="fw-semibold mb-2"> {{ $course->mainCourses->getCourseDept->schools->name }} </span>
                                            <span class="fw-semibold mb-2"> {{ $course->mainCourses->getCourseDept->name }}</span>
                                            <span class="fw-semibold mb-2"> {{ $course->mainCourses->course_name }} </span>
                                        </div>

                                        <table class="table table-sm table-bordered table-striped table-responsive-md">
                                            @if($mycourse != null && $mycourse->receipt != null)
                                                <thead>
                                                <th>Receipt Number</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{ $mycourse->receipt }}</td>
                                                    <td>{{ $course->mainCourses->courseRequirements->fee }}</td>
                                                    <td><span class="badge bg-success"><i class="fa fa-check-circle"> Paid </i> </span> </td>
                                                </tr>
                                                </tbody>
                                            @endif
                                                @if($mycourse != null)
                                                    <thead>
                                                        <th colspan="2">Course Requirements</th>
                                                    </thead>
                                                    <tbody>
                                                        <td colspan="2"> {{ $course->mainCourses->course_requirements }} </td>
                                                    </tbody>
                                                @endif
                                            @if($mycourse != null)
                                                        <thead>
                                                        <th>Cluster subject</th>
                                                        <th colspan="2">Your Score</th>
                                                        </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $course->mainCourses->courseRequirements->subject1 }}</td>
                                                            <td colspan="2">{{ $mycourse->subject_1 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->mainCourses->courseRequirements->subject2 }}</td>
                                                            <td colspan="2">{{ $mycourse->subject_2 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->mainCourses->courseRequirements->subject3 }}</td>
                                                            <td colspan="2">{{ $mycourse->subject_3 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $course->mainCourses->courseRequirements->subject4 }}</td>
                                                            <td colspan="2">{{ $mycourse->subject_4 }}</td>
                                                        </tr>
                                                    </tbody>
                                                @endif

                                        </table>

                            <div class="row">
                                @if($mycourse != null && $mycourse->receipt != null)
                                <form action="{{ route('application.finish') }}" method="POST">
                                    @csrf
                                <div class="col-md-12">
                                    <span>Applicant Declaration</span>
                                    <div class="" style="padding: 7px !important;">
                                        <input type="checkbox" name="declare" required @if($mycourse != null && $mycourse->declaration== 1) disabled @endif>
                                        <input hidden name="course_id" value="@if($mycourse != null) {{ $mycourse->id }} @endif">
                                        I <span class="text-decoration-underline"> {{ Auth::user()->sname }} {{ Auth::user()->mname }} {{ Auth::user()->fname }}</span> declare that the information given in this application form is correct. I further certify that I have read, understood and agreed to comply with the terms stipulated herein.
                                    </div>
                                </div>
                                    <div class="d-flex justify-content-center mb-1 mt-4">
                                        @if($mycourse != null && $mycourse->declaration== 1)
                                            <button class="btn btn-success" disabled> <i class="fa fa-check-circle"></i> Submitted </button>
                                        @else
                                        <button onclick='confirm("Once this application has been submitted cannot be changed. Are you sure you want to submit the application?")' class="btn btn-sm btn-alt-success">Submit Application</button>
                                        @endif
                                    </div>
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
    <!-- Pop In Block Modal -->
    <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Application fee payment</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
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
                        </ul>

                            <span class="text-muted text-center" style="color: red !important;">Application fee is non refundable</span>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
{{--                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Okay</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Pop In Block Modal -->
@endsection



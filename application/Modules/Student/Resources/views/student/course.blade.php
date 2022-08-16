@extends('student::layouts.backend')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src = "{{ asset('js/select.js') }}" defer></script>

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h5 fw-bold mb-2">
                    COURSES
                </h1>
            </div>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                    <a class="link-fx" href="javascript:void(0)">Location</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    CHANGE COURSES
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="content-force">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">CHANGE COURSE</h3>
        </div>
        <div id = 'course_interaction' style = 'width:80%;margin-left:20%;'></div>
    </div>
    <!-- <div id="cut_off_courses"></div> -->
</div>
<!-- END Page Content -->

<script defer>
    getCourses();
</script>

@endsection


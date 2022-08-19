@extends('approval::layouts.backend')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/admissions.css') }}" rel="stylesheet" />
<link href="{{ asset('css/index.css') }}" rel="stylesheet" />
<script src = "{{ asset('js/select.js') }}" defer></script>
<script src = "{{ asset('js/jquery.js') }}" ></script>

<div class = 'content-force'>
    <div id = 'search-section'>
        <div id = 'search-section-left'>
            <div id = 'level-parent'>
                <p>ATTENDANCE</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'attendance_search' name = 'attendance_input'></select>
                </div>
            </div>
            <div id = 'level-parent'>
                <p>COURSE</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'course_search' name = 'course_input'></select>
                </div>
            </div>
            <div id = 'level-parent'>
                <p>YEAR OF STUDY</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'stage_search' name = 'stage_search'></select>
                </div>
            </div>
        </div>
    </div>
    <div id = 'level-page'>
        <span>PAGE</span><select class = 'select_approve' id = 'page_approve' name = 'page_approve' style = 'width : 20%;margin-left:40%;'></select>
    </div>
    <div id = 'candidate-page'></div>
</div>

<script src = "{{ asset('js/build.js') }}"></script>
<script>
    retrievePost();
</script>

<!-- END Page Content -->
@endsection

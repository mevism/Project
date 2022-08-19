@extends('approval::layouts.backend')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/admissions.css') }}" rel="stylesheet" />
<link href="{{ asset('css/index.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src = "{{ asset('js/select.js') }}" defer></script>
<script src = "{{ asset('js/jquery.js') }}" ></script>

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h5 fw-bold mb-2">
                    VIEW INTAKE
                </h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)" id = 'intake_name'></a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" id = 'intake_program'></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class = 'content-force'>
    <div id = 'search-section'>
        <div id = 'search-section-left'>
            <div id = 'level-parent'>
                <p>Attendance</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'attendance_search' name = 'attendance_input'></select>
                </div>
            </div>
            <div id = 'level-parent'>
                <p>Course</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'course_search' name = 'course_input'></select>
                </div>
            </div>
            <div id = 'level-parent'>
                <p>Year of Study</p>
                <div id = 'level-approve'>
                     <i class='fas fa-filter' style = 'margin:1%'></i> <select class = 'select_approve' id = 'stage_search' name = 'stage_search'></select>
                </div>
            </div>
        </div>
    </div>
    <div id = 'level-page'>
        <span>Page</span><select class = 'select_approve' id = 'page_approve' name = 'page_approve' style = 'width : 20%;margin-left:40%;'></select>
        <button id = 'approve-all' class = 'btn btn-success' data-toggle = 'click-ripple'>Approve All</button>
    </div>
    <div id = 'candidate-page'></div>
</div>

<script src = "{{ asset('js/build.js') }}"></script>
<script>
    retrievePost();
</script>

<!-- END Page Content -->
@endsection

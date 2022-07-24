@extends('student::layouts.backend')
@section('content')

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
    <div id = 'cut_off'>
        <input type = 'text' placeholder="Cut Off Points" id = 'cut_off_value' >
    </div>
    <div id="cut_off_courses"></div>
</div>
<!-- END Page Content -->

@endsection

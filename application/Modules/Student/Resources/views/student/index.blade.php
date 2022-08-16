@extends('student::layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h5 fw-bold mb-2">
                    PROFILE
                </h1>
            </div>
        </div>
    </div>
    <div style = 'width:100%;text-align:center;'>
        <img src = '{{ asset('Images/profile.svg') }}' alt = 'Profile Image' style = 'height:30%;width:20%;'>
        <input type = 'file' id = 'input-profile'>
        <button id = 'actual-input' class = 'btn btn-sm btn-alt-info'>Update Image</button>
    </div>
</div>
<div class="content-force">
    <div id="remind_profile"></div>
    <div id = 'student_profile'></div>
</div>
<!-- END Page Content -->

<script async>
    plotProfile();
</script>
@endsection

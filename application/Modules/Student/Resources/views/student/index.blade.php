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
</div>
<div class="content-force">
    <div id = 'student_profile'></div>
</div>
<!-- END Page Content -->

<script async>
    plotProfile();
</script>
@endsection

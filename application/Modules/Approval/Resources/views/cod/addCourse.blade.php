@extends('approval::layouts.backend')
@section('content')
    <!-- Page Content -->

    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
    <script src = "{{ asset('js/plugins/chart.js/Chart.min.js') }}" ></script>
    <script src = "{{ asset('js/utils.js') }}" ></script>
    <script src = "{{ asset('js/jquery.js') }}" ></script>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h5 fw-bold mb-2">
                        ADD COURSES
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content-force">
        <div class="row">
            ADD COURSE
        </div>
    </div>
    <!-- END Page Content -->

    <script src = "{{ asset('/js/build.js') }}"></script>

@endsection

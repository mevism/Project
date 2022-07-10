@extends('application::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        My Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Track progress
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <!-- Developer Plan -->
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-header">
                        <h2 class="block-title fw-bold">
                            {{ $course->courses->course_name }} <span class="text-primary fs-sm fw-normal text-lowercase"> -> logs</span>
                        </h2>
                    </div>
                    <div class="block-content text-start">
                        @foreach($logs as $log)
                            <p class="fs-sm text-success">{{ $log->created_at->format('Y-M-d') }} - {{ $log->activity }} by {{ $log->user }}
                                @if($log->comments != NULL)
                                <span class="text-danger"> : Reason(s) - {{ $log->comments }} </span>
                                @endif
                            </p>
                        @endforeach

                    </div>
                </a>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>
@endsection

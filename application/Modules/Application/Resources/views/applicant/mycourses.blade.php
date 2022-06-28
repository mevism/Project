@extends('application::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h5 fw-bold mb-2">
                        Courses
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-responsive-md table-borderless table-striped">
                        @if(count($courses)>0)
                            <thead>
                            <tr>
                                <th>School</th>
                                <th>Department</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->school }}</td>
                                    <td>{{ $course->department }}</td>
                                    <td>{{ $course->course }}</td>
                                    <td><a class="btn btn-sm btn-alt-secondary" data-toggle="click-ripple" href="#">Track </a></td>
                                    <td><a class="btn btn-sm btn-alt-info" href="{{ route('application.edit', $course->id) }}">Edit</a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <small class="text-center text-muted"> You have not submitted any applications</small>
                        @endif
                    </table>
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

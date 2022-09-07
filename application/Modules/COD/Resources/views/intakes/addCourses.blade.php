@extends('cod::layouts.backend')


@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Intakes
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intake</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Add Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="">
            <div class="col-md-12">
                <!-- Developer Plan -->
                <div class="block block-rounded block-link-shadow" href="javascript:void(0)">
                    <div class="block-header">
                        <h2 class="block-title fw-bold text-center">Add Courses to <span class="text-success">{{ Carbon\carbon::parse($intake->intake_from)->format('M')}} - {{ Carbon\carbon::parse($intake->intake_to)->format('M Y') }} </span> Intake</h2>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="py-1">
                            <p class="mb-1 text-center">
                                Semester Duration {{ Carbon\Carbon::parse($intake->intake_from)->diffInWeeks($intake->intake_to) }} Weeks
                            </p>
                        </div>
                    </div>
                    <div class="block-content">

                        <form action="{{ route('department.addAvailableCourses') }}" method="POST">
                            @csrf

                            <table id="courses" class="table table-striped table-sm-responsive fs-sm">
                                <thead>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>Mode of Study</th>
                                    <th>Offered in</th>
                                </thead>
                                <tbody >
                                @foreach($courses as $key => $course)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <input name="course_id[]" value="{{ $course->id }}" type="checkbox">
                                            <input name="intake_id" value="{{ $intake->id }}" type="hidden">
                                            <input name="course_code[]" value="{{ $course->course_code }}" type="hidden">
                                            <label>{{ $course->course_name }}</label>
                                        </td>
                                        <td>
                                            @foreach($modes as $key => $mode)
                                                <p class="">
                                                    {{ ++$key }}
                                                    <input name="attendance_id[]" type="checkbox" value="{{ $mode->id }}">
                                                    <input name="attendance_code[]" type="hidden" value="{{ $mode->attendance_code }}">
                                                    <label>{{ $mode->attendance_name }}</label>
                                                </p>
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach($campuses as $key => $campus)
                                                <p>
                                                    {{ ++$key }}
                                                    <input name="campus_id[]" type="checkbox" value="{{ $campus->id }}">
                                                    <label>{{ $campus->name }}</label>
                                                </p>
                                            @endforeach
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-alt-success mb-4" data-toggle="click-ripple" onclick="return confirm('You are about to add courses to {{ Carbon\carbon::parse($intake->intake_from)->format('M')}} - {{ Carbon\carbon::parse($intake->intake_to)->format('M Y') }} intake. Are you sure you want to proceed?')">Save courses</button>
                            </div>

                        </form>

                    </div>
                    <div class="block-content block-content-full bg-body-light text-center">

                    </div>
                </div>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>


@endsection

<script>



</script>

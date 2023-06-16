@extends('cod::layouts.backend')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <table class="table table-striped table-sm-responsive fs-sm">
                                <thead>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Mode of Study</th>
                                <th>Offered in</th>
                                </thead>
                                <tbody>
                                @foreach($courses as $key => $course)
                                    <tr id="{{ $course->course_id }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <input name="course[]" value="{{ $course->course_id }}" type="checkbox">
                                            <label>{{ $course->course_name }}</label>
                                        </td>
                                        <td>
                                            @foreach($modes as $key => $mode)
                                                <p class="">
                                                    {{ ++$key }}
                                                    <input name="modes[{{ $course->course_id }}][]" type="checkbox" value="{{ $mode->id }}">
                                                    <label> {{ $mode->attendance_name }} </label>
                                                </p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($campuses as $key => $campus)
                                                <p>
                                                    {{ ++$key }}
                                                    <input name="campuses[{{ $course->course_id }}][]" type="checkbox" value="{{ $campus->campus_id }}">
                                                    <label>{{ $campus->name }}</label>
                                                </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-alt-success mb-4" onclick="preparePayload()">Save courses</button>
                            </div>
                            <input type="hidden" id="payloadInput" name="payload" value="">
                            <input type="hidden" id="intake" name="intake" value="{{ $intake->intake_id }}">
                        </form>

                        <script>
                            function preparePayload() {
                                var payload = [];

                                $('table tbody tr').each(function() {
                                    var row = $(this);
                                    var courseId = row.find('input[name="course[]"]').val();
                                    var selectedModes = row.find('input[name="modes[' + courseId + '][]"]:checked').map(function() {
                                        return $(this).val();
                                    }).get();
                                    var selectedCampuses = row.find('input[name="campuses[' + courseId + '][]"]:checked').map(function() {
                                        return $(this).val();
                                    }).get();

                                    var rowObject = {
                                        course: courseId,
                                        modes: selectedModes,
                                        campus: selectedCampuses
                                    };

                                    payload.push(rowObject);
                                });

                                $('#payloadInput').val(JSON.stringify(payload));
                            }
                        </script>

                    </div>
                </div>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>
<!-- END Page Content -->
@endsection

{{--<script>--}}
{{--    var payload = [];--}}

{{--    // Iterate through each row of the table--}}
{{--    $('table tr').each(function() {--}}
{{--        var row = $(this);--}}
{{--        var courseName = row.find('td input[name="course"]').next().text().trim(); // Get the course name--}}

{{--        // Find the selected campuses for the current row--}}
{{--        var selectedCampuses = row.find('td input[name="campus"]:checked').map(function() {--}}
{{--            return $(this).next().text().trim();--}}
{{--        }).get();--}}

{{--        // Find the selected modes of study for the current row--}}
{{--        var selectedModes = row.find('td input[name="mode"]:checked').map(function() {--}}
{{--            return $(this).next().text().trim();--}}
{{--        }).get();--}}

{{--        // Construct the object for the current row--}}
{{--        var rowObject = {--}}
{{--            course: courseName,--}}
{{--            modes: selectedModes,--}}
{{--            campus: selectedCampuses--}}
{{--        };--}}

{{--        // Push the row object to the payload array--}}
{{--        payload.push(rowObject);--}}
{{--    });--}}

{{--    // Assign the payload to a hidden input field in your form--}}
{{--    $('#payloadInput').val(JSON.stringify(payload));--}}

{{--</script>--}}

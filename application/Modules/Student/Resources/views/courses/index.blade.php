@extends('student::layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>


<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>


@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        My Course
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('student') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Enrolled Course
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
                <div class="row">
                    @if(count($others) > 0)
                        <div class="col-md-7 table-responsive">
                            <h6 style="margin-left: 5% !important;">Currently Enrolled Course</h6>
                            <div class="block-content fs-sm">
                                <!-- Introduction -->
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr class="table-active fs-sm">
                                        <th style="width: 50px;"></th>
                                        <th>{{ $course->course_name }}</th>
                                    </tr>
                                    <tr>
                                        <td class="table-success text-center">
                                            <i class="fa fa-fw fa-clock text-success"></i>
                                        </td>
                                        <td>
                                            <span><b>Course Duration:</b> {{ $course->course_duration }} </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-success text-center">
                                            <i class="fa fa-fw fa-user-graduate text-success"></i>
                                        </td>
                                        <td>
                                            <span><b>Entry Grade:</b> {{ $course->course_requirements }} </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- END Introduction -->

                                <!-- Basics -->
                                <table class="table table-borderless table-vcenter">
                                    <tbody>
                                    <tr class="table-active">
                                        <th style="width: 50px;"></th>
                                        <th>Course Details</th>
                                    </tr>
                                    <tr>
                                        <td class="table-info text-center">
                                            <i class="fa fa-fw fa-building text-success"></i>
                                        </td>
                                        <td>
                                            <span> <b>Department: </b> {{ $course->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-info text-center">
                                            <i class="fa fa-fw fa-clock-rotate-left text-success"></i>
                                        </td>
                                        <td>
                                            <span> <b>Intake: </b> {{ strtoupper(Carbon\Carbon::parse($course->intake_from)->format('MY')) }} </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- END Basics -->

                                <!-- Advanced -->
                                <table class="table table-borderless table-vcenter">
                                    <tbody>
                                    <tr class="table-active">
                                        <th style="width: 50px;"></th>
                                        <th>Registration Status</th>
                                    </tr>
                                    <tr>
                                        <td class="table-primary text-center">
                                            <i class="fa fa-fw fa-step-forward text-success"></i>
                                        </td>
                                        <td>
                                    <span> <b> Stage: </b>
                                            @if($reg != null)
                                            {{ 'Y'.$reg->year_study.'S'.$reg->semester_study }}
                                        @else
                                            <span class="text-info">Awaiting Registration</span>
                                        @endif
                                    </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-primary text-center">
                                            <i class="fa fa-fw fa-exclamation-triangle text-success"></i>
                                        </td>
                                        <td>
                                    <span>
                                        <b>Status</b>
                                        @if($reg != null)
                                            <span class="text-success">Registered</span>
                                        @else
                                            <span class="text-danger">Not Registered</span>
                                        @endif
                                    </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- END Advanced -->
                            </div>
                        </div>
                        <div class="col-md-5 table-responsive">
                            <h6 style="margin-left: 5% !important;">Previously Enrolled Course</h6>
                            @foreach($others as $other)
                                <div class="block-content fs-sm">
                                    <!-- Introduction -->
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr class="table-active fs-sm">
                                            <th style="width: 50px;"> {{ $loop->iteration }} </th>
                                            <th> {{ $other->OldCourse->course_name }}</th>
                                        </tr>
                                        <tr>
                                            <td class="table-success text-center">
                                                <i class="fa fa-fw fa-clock text-success"></i>
                                            </td>
                                            <td>
                                                <span><b>Course Duration:</b> {{ $other->OldCourse->courseRequirement->course_duration }} </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-success text-center">
                                                <i class="fa fa-fw fa-user-graduate text-success"></i>
                                            </td>
                                            <td>
                                                <span><b>Entry Grade:</b> {{ $other->OldCourse->courseRequirement->course_requirements }} </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Introduction -->

                                    <!-- Basics -->
                                    <table class="table table-borderless table-vcenter">
                                        <tbody>
                                        <tr class="table-active">
                                            <th style="width: 50px;"></th>
                                            <th>Course Details</th>
                                        </tr>
                                        <tr>
                                            <td class="table-info text-center">
                                                <i class="fa fa-fw fa-building text-success"></i>
                                            </td>
                                            <td>
                                                <span> <b>Department: </b> {{ $other->OldCourse->getCourseDept->name }} </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-info text-center">
                                                <i class="fa fa-fw fa-clock-rotate-left text-success"></i>
                                            </td>
                                            <td>
                                                <span> <b>Intake: </b> {{ strtoupper(Carbon\Carbon::parse(\Modules\Registrar\Entities\Intake::where('intake_id', $other->intake_id)->first()->intake_from)->format('MY')) }} </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <!-- END Basics -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <div class="col-md-8 table-responsive">
                                <h6 style="margin-left: 5% !important;">Currently Enrolled Course</h6>
                                <div class="block-content fs-sm">
                                    <!-- Introduction -->
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr class="table-active fs-sm">
                                            <th style="width: 50px;"></th>
                                            <th>{{ $course->course_name }}</th>
                                        </tr>
                                        <tr>
                                            <td class="table-success text-center">
                                                <i class="fa fa-fw fa-clock text-success"></i>
                                            </td>
                                            <td>
                                                <span><b>Course Duration:</b> {{ $course->course_duration }} </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-success text-center">
                                                <i class="fa fa-fw fa-user-graduate text-success"></i>
                                            </td>
                                            <td>
                                                <span><b>Entry Grade:</b> {{ $course->course_requirements }} </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Introduction -->

                                    <!-- Basics -->
                                    <table class="table table-borderless table-vcenter">
                                        <tbody>
                                        <tr class="table-active">
                                            <th style="width: 50px;"></th>
                                            <th>Course Details</th>
                                        </tr>
                                        <tr>
                                            <td class="table-info text-center">
                                                <i class="fa fa-fw fa-building text-success"></i>
                                            </td>
                                            <td>
                                                <span> <b>Department: </b> {{ $course->name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-info text-center">
                                                <i class="fa fa-fw fa-clock-rotate-left text-success"></i>
                                            </td>
                                            <td>
                                                <span> <b>Intake: </b> {{ strtoupper(Carbon\Carbon::parse($course->intake_from)->format('MY')) }} </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Basics -->

                                    <!-- Advanced -->
                                    <table class="table table-borderless table-vcenter">
                                        <tbody>
                                        <tr class="table-active">
                                            <th style="width: 50px;"></th>
                                            <th>Registration Status</th>
                                        </tr>
                                        <tr>
                                            <td class="table-primary text-center">
                                                <i class="fa fa-fw fa-step-forward text-success"></i>
                                            </td>
                                            <td>
                                    <span> <b> Stage: </b>
                                            @if($reg != null)
                                            {{ 'Y'.$reg->year_study.'S'.$reg->semester_study }}
                                        @else
                                            <span class="text-info">Awaiting Registration</span>
                                        @endif
                                    </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-primary text-center">
                                                <i class="fa fa-fw fa-exclamation-triangle text-success"></i>
                                            </td>
                                            <td>
                                    <span>
                                        <b>Status</b>
                                        @if($reg != null)
                                            <span class="text-success">Registered</span>
                                        @else
                                            <span class="text-danger">Not Registered</span>
                                        @endif
                                    </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Advanced -->
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
        </div>
    </div>

@endsection

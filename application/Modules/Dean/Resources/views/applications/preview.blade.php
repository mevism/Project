@extends('dean::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Update Application Status
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Status
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-5 mb-1 fs-sm">
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Applicant Name </div>
                            <div class="col-md-8"> {{ $app->sname }} {{ $app->fname }} {{ $app->mname }}</div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Department</div>
                            <div class="col-md-8"> {{ $app->DepartmentCourse->getCourseDept->name }} </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Course Name</div>
                            <div class="col-md-8"> {{ $app->DepartmentCourse->course_name }} </div>
                        </div>
                        <div class="row p-1">
                            @foreach($school as $key => $institute)
                                <p>{{ ++$key }}. {{ $institute->institution }} Level: {{ $institute->level }} </p>
                                <p>Qualification: {{ $institute->qualification }}</p>
                            @endforeach
                        </div>
                        <div class="row py-3">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-borderless">
                                    <th>Course Requirement</th>
                                    <th>Applicant Score</th>
                                    <tbody>
                                    <tr>
                                        <td>{{ $app->DepartmentCourse->courseRequirements->subject1 }}</td>
                                        <td>{{ $app->subject_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $app->DepartmentCourse->courseRequirements->subject2 }}</td>
                                        <td>{{ $app->subject_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $app->DepartmentCourse->courseRequirements->subject3 }}</td>
                                        <td>{{ $app->subject_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $app->DepartmentCourse->courseRequirements->subject4 }}</td>
                                        <td>{{ $app->subject_4 }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($app->dean_status == 2)

                            <div class="row p-1">
                                <div class="col-md-4 fw-bolder text-start">Why rejected?</div>
                                <div class="col-md-8">
                                    <p>{{ $app->dean_comments }}</p>
                                </div>
                            </div>

                        @endif
                    </div>
                    <div class="col-lg-7 space-y-1">
                        <div id="carouselExampleControls" class="carousel carousel-dark slide" data-interval="50000" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($school as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <iframe src="{{ url('certs/', $item->certificate) }}" type="application/pdf" style="width: 100% !important; height: 80vh !important;"> </iframe>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center py-1">
              <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="{{ route('dean.applications') }}">Close</a>
            </div>
        </div>
    </div>

@endsection

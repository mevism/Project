@extends('layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Courses
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
            <table class="table table-borderless table-striped js-dataTable-responsive">
                @csrf
    @method('delete') 
                @if(count($availables)>0)
                    <tr>
                        <th>Course name</th>
                        <th>Department</th>
                        <th>School</th>
                        <th>Intake</th>
                        <th>Duration</th>
                        <th colspan="2" class="text-center">Action</th>
                    </tr>
                    @foreach($availables as $course)

                        @foreach($course as $item)
                            <tr>
                                <td> {{ $item->course_name }}</td>
                                <td> {{ $item->department_id }}</td>
                                <td> {{ $item->school_id }}</td>
                                <td> {{ $item->$intake }}</td>
                                <td> {{ $item->course_duration }}</td>
                                {{-- <td nowrap=""> <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.viewOne', $item->id) }}">view </a> </td> --}}
                                {{-- <td nowrap=""> <a class="btn btn-sm btn-alt-info" href="{{ route('courses.apply', $item->id) }}">edit </a> </td> --}}
                                <td nowrap=""> <a class="btn btn-sm btn-alt-danger" href="{{ route('courses.destroyCoursesAvailable', $item->id) }}">delete </a> </td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                <tr>
                    <small class="text-center text-muted">There are no courses on offer</small>
                </tr>
                @endif
        </table>
        {{-- {{ $course_id->links('pagination::bootstrap-5') }} --}}
        </div>
            </div>
        </div>
    </div>
@endsection


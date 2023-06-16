@extends('registrar::layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        EDIT ACADEMIC YEAR
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Academic Year</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a  href="academicYear">View Academic Years</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="d-flex justify-content-center">
                    <div class="col-lg-6 space-y-0">

                        <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.updateAcademicYear', $academicYear->year_id) }}" method="POST">
                            @csrf
                            <div class="form-floating col-12 col-xl-12 mb-2">
                                <input type="date" class="form-control form-control-sm" name="year_start" value="{{ Carbon\Carbon::parse($academicYear->year_start)->format('Y-m-d') }}" placeholder="Year From">
                                <label class="form-label">YEAR FROM</label>
                            </div>
                            <div class="form-floating col-12 col-xl-12 mb-2">
                                <input type="date" class="form-control form-control-sm" value="{{ Carbon\Carbon::parse($academicYear->year_end)->format('Y-m-d') }}" name="year_end" placeholder="Year To">
                                <label class="form-label">YEAR TO</label>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Dates</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('registrar::layouts.backend')
@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <div class="flex-grow-1">
                <h6 class="block-title">IMPORT COURSES</h6>
            </div>      
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="col-lg-6 space-y-0">
                        <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.importCourses') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-12 col-xl-12">
                                    <label class="mb-2 fw-bold">File Import</label>
                                    <input type="file" name="excel_file" class="form-control">
                            </div>
                            <br>
                            <div class="col-12 col-xl-12">
                                    <button type="submit" class="btn btn-alt-success mb-3">Import </button>
                            </div>
                        </form>       
                    </div>
                </div>
                @if(count($courses) > 0)
                    <div class="d-flex justify-content-center">
                        <span class="text-success"> You have imported {{ count($courses) }} courses </span> 
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

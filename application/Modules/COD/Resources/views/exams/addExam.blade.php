@extends('cod::layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                       Add Exam Results
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Student Results
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="d-flex justify-content-center">
                <div class="col-md-6 space-y-0">
                <form method="POST" action="{{ route('department.submitResults') }}">
                    @csrf
                    <div class="row row-cols-sm-1 g-2">
                        <div class="form-floating mb-2">
                            <select name="student" class="form-control form-select">
                                <option selected disabled class="text-center"> -- select student -- </option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"> {{ $student->reg_number }} {{ $student->sname.' '.$student->fname.' '.$student->mname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-floating mb-2">
                            <select name="stage" class="form-control form-select">
                                <option selected disabled class="text-center"> -- select stage -- </option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                                <option value="5">Year 5</option>
                            </select>
                        </div>
                        <div class="form-floating mb-2">
                            <select name="status" class="form-control form-select">
                                <option selected disabled class="text-center"> -- select status -- </option>
                                <option value="1">Pass</option>
                                <option value="2">Fail</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-success col-md-7" data-toggle="click-ripple">Save Result</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection

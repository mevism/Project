@extends('cod::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Application Submission
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Batch submission
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
                    <table class="table table-responsive-sm table-borderless table-striped js-dataTable-responsive">
                        @if(count($apps)>0)
                            <thead>
                            <th>✔</th>
                            <th>Applicant Name</th>
                            <th>Course Name</th>
                            <th>Department </th>
                            <th>Status</th>
                            </thead>
                            <tbody>
                            @foreach($apps as $app)
                                <tr>
                                    <td>
                                    @if($app->dean_status === null || 3)
                                        <form action="{{ route('cod.batchSubmit') }}" method="post">
                                            @csrf
                                    <input class="batch" type="checkbox" name="submit[]" value="{{ $app->id }}" required>
                                        @else
                                        ✔
                                    @endif
                                    </td>
                                    <td> {{ $app->applicant->sname }} {{ $app->applicant->fname }} {{ $app->applicant->mname }}</td>
                                    <td> {{ $app->course }}</td>
                                    <td> {{ $app->department }}</td>
                                    <td>
                                        @if($app->cod_status === 0)
                                            <span class="badge bg-primary">Awaiting</span>
                                        @elseif($app->cod_status === 1)
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($app->cod_status === 2)
                                            <span class="badge bg-warning">Rejected</span>
                                        @else
                                            <span class="badge bg-primary">Awaiting</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no applications awaiting batch submission</span>
                            </tr>
                        @endif
                    </table>
                    @if(count($apps)>0)
                        <div>
                            <input type="checkbox" onclick="for(c in document.getElementsByClassName('batch')) document.getElementsByClassName('batch').item(c).checked = this.checked"> Select all
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-alt-primary" data-toggle="click-ripple">Submit batch</button>
                        </div>
                        @endif
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

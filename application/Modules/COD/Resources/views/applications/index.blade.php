@extends('cod::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Application Approval
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Approvals
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
                            <th>Applicant Name</th>
                            <th>Course Name</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th colspan="2" class="text-center">Action</th>
                            </thead>
                            <tbody>
                            @foreach($apps as $app)
                            <tr>
                                <td> {{ $app->applicant->sname }} {{ $app->applicant->fname }} {{ $app->applicant->mname }} </td>
                                <td> {{ $app->course }}</td>
                                <td> {{ $app->department }}

                                </td>
                                <td>
                                        @if($app->cod_status === 0)
                                            <span class="badge bg-primary">Awaiting</span>
                                        @elseif($app->cod_status === 1)
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($app->cod_status === 2)
                                            <span class="badge bg-warning">Rejected</span>
                                        @elseif($app->cod_status === 4)
                                            <span class="badge bg-success">Reviewed</span>
                                        @else
                                        <span class="badge bg-info">Review</span>
                                        @endif

                                </td>
                                    @if($app->cod_status === 0)
                                <td><a class="btn btn-sm btn-alt-secondary" href="{{ route('cod.viewApplication', $app->id) }}"> View </a></td>
                                        @else
                                <td><a class="btn btn-sm btn-alt-secondary" href="{{ route('cod.previewApplication', $app->id) }}"> View </a></td>
                                <td><a class="btn btn-sm btn-alt-info" href="{{ route('cod.viewApplication', $app->id) }}"> Edit </a></td>
                                @endif
                            </tr>
                            @endforeach
                            </tbody>
                        @else
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no new applications submitted</span>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

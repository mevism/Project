@extends('layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Home
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Home</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Content -->
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Courses on offer</div>
                        <div class="fs-2 fw-normal text-dark">1,200</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Applications</div>
                        <div class="fs-2 fw-normal text-dark">665 <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New </span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Notifications</div>
                        <div class="fs-2 fw-normal text-dark">9+ <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New</span> </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>
    <!-- END Page Content -->
@endsection

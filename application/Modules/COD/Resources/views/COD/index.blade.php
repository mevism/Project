@extends('cod::layouts.backend')
@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row  align-items-sm-center">
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                     Dashboard | Chairperson of Department
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">COD</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" >
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('cod.applications') }}">
                        <div class="block-content block-content-full">
                            <div class="fs-sm fw-semibold text-uppercase text-muted">Pending Applications </div>
                            <div class="fs-2 fw-normal text-dark">
                                {{ $apps }}
                            </div>
                        </div>
                    </a>
                </div>

            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('cod.Admissions') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Pending Admissions </div>
                        <div class="fs-2 fw-normal text-dark">
                            {{ $admissions }}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="{{ route('department.classes') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Department Classes </div>
                        <div class="fs-2 fw-normal text-dark">
                            {{ $classes }}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- END Stats -->
    </div>
@endsection

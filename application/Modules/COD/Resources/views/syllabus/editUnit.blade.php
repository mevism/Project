@extends('cod::layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        Department Units
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department Unit</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update Unit
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="table-responsive col-12">
                    <form method="POST" action="{{ route('department.updateUnit', $unit->unit_id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="border p-2" style="height: 100% !important;">
                                    <legend class="float-none w-auto h6">Unit Details</legend>
                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="unit_code" value="{{ $unit->unit_code }}" placeholder="unit code">
                                        <label>UNIT CODE <sup class="text-danger">*</sup> </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="unit_name" value="{{ $unit->unit_name }}" placeholder="unit code">
                                        <label>UNIT NAME <sup class="text-danger">*</sup> </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <select class="form-control" name="unit_type" >
                                            <option selected disabled class="text-center"> -- select -- </option>
                                            <option @if($unit->type == 1) selected @endif value="1">University Unit</option>
                                            <option @if($unit->type == 2) selected @endif value="2">Faculty Unit</option>
                                            <option @if($unit->type == 3) selected @endif value="3">Department Unit</option>
                                        </select>
                                        <label>UNIT CODE <sup class="text-danger">*</sup> </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <input type="number" class="form-control" name="total_exam" value="{{ $unit->total_exam }}" placeholder="unit code">
                                        <label>TOTAL EXAM MARK <sup class="text-danger">*</sup> </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="total_cat" value="{{ $unit->total_cat }}" placeholder="unit code">
                                        <label>TOTAL CAT MARK <sup class="text-danger">*</sup> </label>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="border p-2" style="height: 100% !important;">
                                    <legend class="float-none w-auto h6">Unit Grade Composition</legend>

                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="cat" value="{{ $unit->cat }}" placeholder="unit code">
                                        <label>CAT <sup class="text-danger">*</sup> </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="assignment" value="{{ $unit->assignment }}" placeholder="unit code">
                                        <label>ASSIGNMENT(s) </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        <input type="text" class="form-control" name="practical" value="{{ $unit->practical }}" placeholder="unit code">
                                        <label>PRACTICAL(S) </label>
                                    </div>

                                    <p>All fields marked <sup class="text-danger">*</sup> must be filled </p>
                                    <p>The summation of <b>CAT, ASSIGNMENT & PRACTICAL</b> must total to <b>TOTAL CAT</b></p>
                                    <p>Ensure that the correct type of unit is selected</p>
                                </fieldset>
                            </div>
                            <div class="mt-4 d-flex justify-content-center">
                                <button class="btn btn-md btn-outline-success col-md-7">Update Unit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@extends('lecturer::layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0">
                   Edit My Qualifications
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Profile</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Edit Qualifications
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
            <form method="POST" action="{{ route('lecturer.updateQualifications', $qualification->id) }}">
                @csrf
                <div class="row row-cols-sm-1 g-2">
                    <div class="form-floating mb-2">
                        <select name="level" class="form-control form-select">
                              <option value="" selected disabled>-- select level --</option>
                              <option @if($qualification->level == 'PHD')selected @endif value="PHD">PHD</option>
                              <option @if($qualification->level =='Masters')selected @endif value="Masters">Masters</option>
                              <option @if($qualification->level == 'Bachelors')selected @endif value="Bachelors">Bachelors</option>

                            
                        </select>
                        <label for="">Education Level</label>
                    </div>
                    <div class="form-floating mb-2">
                      <input type="text" name="institution" class="form-control " value="{{ $qualification->institution}}" placeholder="Institution Name">
                      <label>Institution Name </label>
                    </div>
                   
                    <div class="form-floating mb-2">
                        <input type="text" name="qualification" class="form-control " value="{{ $qualification->qualification}}"placeholder="qualification Name">
                        <label>Qualification </label>
                      </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-success col-md-7" data-toggle="click-ripple">Update Qualification</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection
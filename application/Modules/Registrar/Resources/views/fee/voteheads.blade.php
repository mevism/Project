@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
          <h6 class="block-title">ADD VOTEHEAD</h6>
        </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Voteheads</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showVoteheads">View Voteheadss</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div  class="block block-rounded col-md-12 col-lg-12 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row">
                  <div class="d-flex justify-content-center">
                    <div class="col-lg-6 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeVoteheads') }}" method="POST">
                    @csrf
                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ old('vote_id') }}"  class="form-control  text-uppercase" id="vote_id" name="vote_id" placeholder="Votehead ID ">
                      <label class="form-label">Votehead ID</label>
                    </div>
                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ old('name') }}"  class="form-control  text-uppercase" id="name" name="name" placeholder="Name ">
                      <label class="form-label">Name</label>
                    </div>
                     <div class="form-floating col-12 col-xl-12">
                      <textarea name="description" class="form-control" style="height: 50px !important;" placeholder="description"></textarea>
                      <label>Description</label>
                    </div>  
                     <div class="form-floating col-12 col-xl-12">
                      <input type="hidden" name="type">
                      <select name="type"  class="form-control" required>
                          <option selected disabled class="text-center">-- select type --</option>
                          <option value="1">Fee</option>
                          <option value="2">Fine</option>
                          <option value="3">Accommodation</option>
                          <option value="4">Graduation</option>
                      </select>
                      <label>Type</label>
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Votehead</button>
                    </div>
                  </form>
                </div>
                  </div>
              </div>
            </div>
          </div>
    </div>
@endsection

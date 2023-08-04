@extends('registrar::layouts.backend')
<style>
    /* Custom CSS to make form-floating elements smaller */
    .form-floating .form-control {
        height: 2.95rem !important;
        padding: 0.75rem 0.75rem 0 0.75rem !important;
        font-size: 0.875rem !important;
    }

    .form-floating label {
        font-size: 0.85rem !important;
    }

</style>

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
          <h6 class="block-title">EDIT VOTEHEAD</h6>
        </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">EDIT VOTEHEAD</a>
                  </li>
                   <li class="breadcrumb-item" aria-current="page">
                    <a  href="#">UPDATE VOTEHEAD</a>
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

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.updateVotehead',$data->votehead_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="{{ $data->vote_name }}"  class="form-control text-uppercase" name="name" placeholder="Name ">
                      <label class="form-label">VOTE NAME</label>
                    </div>
                       <div class="form-floating col-12 col-xl-12">
                           <input type="text" value="{{ $data->vote_id }}"  class="form-control text-uppercase" name="voteID" placeholder="Name ">
                           <label class="form-label">VOTE ID</label>
                       </div>
                       <div class="form-floating col-12 col-xl-12">
                           <select class="form-control" name="category">
                               <option @if($data->vote_category == 1) selected @endif value="1">FEES</option>
                               <option @if($data->vote_category == 2) selected @endif value="2">FINES</option>
                               <option @if($data->vote_category == 3) selected @endif value="3">OTHERS</option>
                           </select>
                           <label class="form-label">VOTE CATEGORY</label>
                       </div>
                       <div class="form-floating col-12 col-xl-12">
                           <select class="form-control" name="type">
                               <option @if($data->vote_type == 1) selected @endif value="1">INCOME</option>
                               <option @if($data->vote_type == 2) selected @endif value="2">LIABILITY</option>
                           </select>
                          <label class="form-label">VOTE TYPE</label>
                       </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Edit Votehead</button>
                    </div>
                  </form>
                </div>
              </div>
              </div>
            </div>
          </div>
    </div>
@endsection

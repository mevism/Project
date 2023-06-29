@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="h6 fw-bold mb-0">
                  ADD COURSE FEE STRUCTURE
              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Semester Fee</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showSemFee">View Semester Fee</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div class="block block-rounded col-md-9 col-lg-8 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form action="{{ route('courses.storeSemFee') }}" method="POST">
                    @csrf
                       <div class="row row-cols-sm-3 g-2">
                           <div class="form-floating mb-2">
                               <select name="course" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Course -- </option>
                                   @foreach ($courses as $key => $course)
                                       <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                                   @endforeach
                               </select>
                               <label>Course Name</label>
                           </div>

                           <div class="form-floating mb-2">
                               <select name="level" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Level --</option>
                                   @foreach ($levels as $level)
                                       <option value="{{ $level->id }}">{{ $level->name }}</option>
                                   @endforeach
                                   {{-- <label class="form-label">LEVEL</label> --}}
                               </select>
                               <label>Course Level</label>
                           </div>

                           <div class="form-floating col">
                               <select name="attendance" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Mode -- </option>
                                   @foreach ($modes as $mode)
                                       <option value="{{ $mode->id }}">{{ $mode->attendance_code }}</option>
                                   @endforeach
                               </select>
                               <label>Course Mode of Study</label>
                           </div>

                           <label class="fw-bold mb-2 mt-4">FEE DESCRIPTION</label>
                           <label class="fw-bold mb-2 mt-4">SEMESTER I (KSHS.)</label>
                           <label class="fw-bold mb-2 mt-4">SEMESTER II (KSHS.)</label>

                           @foreach($votes as $vote)
                           <div class="mb-4">
                               <input name="voteheads[]" type="hidden" value="{{ $vote->votehead_id }} ">
                               <label for=""> {{ $vote->name }}</label>
                           </div>
                           <div class="mb-4">
                               <input name="semester1[]" type="text" class="form-control">
                           </div>
                           <div class="mb-4">
                               <input name="semester2[]" type="text" class="form-control">
                           </div>
                           @endforeach

                       </div>
                       <div class="d-flex justify-content-center text-center mt-4">
                           <button class="btn btn-alt-success col-5" data-toggle="click-ripple" type="submit"> Create Fee Structure </button>
                       </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection

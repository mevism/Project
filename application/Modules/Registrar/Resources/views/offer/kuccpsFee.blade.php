@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="h3 fw-bold mb-2">
               FEE STRUCTURE
              </h4>
          </div>     
      </div>
  </div>
</div>

<div class="content">
  <!-- Inline -->
  <div class="block block-rounded">
    <div class="block-content block-content-full">
      <div class="row">
        <div class="col-lg-10 space-y-2">
      
          <!-- Form Inline - Default Style -->
          <form action="{{ route('courses.storeFee') }}" method="POST">
            @csrf 
            <div class="form-floating  col-6 col-xl-6 mb-2">
              <select name="modeofstudy" id="modeofstudy" class="form-control form-control-sm text-uppercase form-select">
                <option selected disabled> Select Study Mode </option>
                @foreach ($modeofstudy as $item)
                <option value="{{ $item->id }}">{{ $item->code }}</option>        
                @endforeach
                <label class="form-label">MODE OF STUDY</label>
              </select>
            </div>

            <div class="row mb-4">
              <div class="form-floating  col-6 col-xl-6 mb-2">
                <select name="level" id="level" class="form-control form-control-sm text-uppercase form-select">
                  <option disabled selected>Level of Study</option>
                  <option value="1">CERTIFICATE</option>
                  <option value="2">DIPLOMA</option>
                  <option value="3">UNDERGRADUATE</option>
                  <option value="4">GRADUATE</option>
                  <option value="5">POSTGRADUATE</option>
                  <option value="6">NON-STANDARD</option>
                  <label class="form-label">LEVEL</label>
                </select>
              </div>
              <div class="form-floating  col-6 col-xl-6 mb-2">
                <select name="course" id="course" class="form-control form-control-sm text-uppercase form-select">
                  <option selected disabled> Select Course </option>
                  @foreach ($course as $item)
                  <option value="{{ $item->id }}">{{ $item->course_name }}</option>        
                  @endforeach
                  <label class="form-label">COURSE NAME</label>
                </select>
              </div>
            
            </div>
            <div class="row row-cols-lg-3 g-4 justify-content-center">
            
            <div class="col-12">
              <p class="fw-bold">DESCRIPTION</p>
            </div>
            <div class="col-12">
              <p class="fw-bold">Y1S1</p>
            </div>
            <div class="col-12">
              <p class="fw-bold">Y1S2 (SUBSEQUENT)</p>
            </div>
            <div class="col-12">
              <p class="fw-semi-bold" >CAUTION MONEY</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('caution_money') }}" name="caution_money" class="form-control">
            </div>
            <div class="col-12 ">
              <input type="text" value="{{ old('caution_money1') }}"  name="caution_money1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >STUDENT UNION</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('student_union') }}"  name="student_union" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('student_union1') }}"name="student_union1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >MEDICAL LEVY</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('medical_levy') }}"name="medical_levy" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('medical_levy1') }}" name="medical_levy1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">TUITION FEE</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('tuition_fee') }}" name="tuition_fee" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('tuition_fee1') }}" name="tuition_fee1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >INDUSTRIAL ATTACHMENT</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('industrial_attachment') }}" name="industrial_attachment" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('industrial_attachment1') }}" name="industrial_attachment1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">STUDENT ID</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('student_id') }}" name="student_id" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('student_id1') }}" name="student_id1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">EXIMANATION</p>
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('examination') }}" name="examination" class="form-control">
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('examination1') }}" name="examination1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">REGISTRATION FEE</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('registration_fee') }}" name="registration_fee" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('registration_fee1') }}"name="registration_fee1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">LIBRARY LEVY</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('library_levy') }}" name="library_levy" class="form-control">
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('library_levy1') }}" name="library_levy1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">I.C.T LEVY</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('ict_levy') }}" name="ict_levy" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('ict_levy1') }}"name="ict_levy1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">ACTIVITY FEE</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('activity_fee') }}" name="activity_fee" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('activity_fee1') }}"name="activity_fee1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">STUDENT BENEVOLENT</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('student_benevolent') }}" name="student_benevolent" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('student_benevolent1') }}"name="student_benevolent1" class="form-control">
            </div>


            <div class="col-12">
              <p class="fw-semi-bold">KUCCPS PLACEMENT FEE</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('kuccps_placement_fee') }}" name="kuccps_placement_fee" class="form-control">
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('kuccps_placement_fee1') }}" name="kuccps_placement_fee1" class="form-control">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">CUE LEVY</p>
            </div>
            <div class="col-12">
              <input type="text"value="{{ old('cue_levy') }}" name="cue_levy" class="form-control">
            </div>
            <div class="col-12">
              <input type="text" value="{{ old('cue_levy1') }}"name="cue_levy1" class="form-control">
            </div>

            <div class="col-12 text-center p-3">
              <button type="submit" class=" btn btn-alt-success" data-toggle="click-ripple">Submit</button>
            </div>
            </div>
          </form>
          <!-- END Form Inline - Default Style -->

        </div>
      </div>
    </div>
  </div>
</div>  
  <!-- END Inline -->

    
@endsection
@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)"></a>
                  </li>
                  
              </ol>
          </nav>
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
              <div class="col-6 col-xl-6 mb-2 ml-2">
                <input type="checkbox" value="1" name="student_type[]">
                <label for="student_type" class="form-label"> S-FT </label>

                <input type="checkbox" value="2" name="student_type[]">
                <label for="student_type" class="form-label"> J-FT </label>
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
              <input type="text" name="caution_money" class="form-control" value="00.00">
            </div>
            <div class="col-12 ">
              <input type="text" name="caution_money1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >STUDENT UNION</p>
            </div>
            <div class="col-12">
              <input type="text" name="student_union" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="student_union1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >MEDICAL LEVY</p>
            </div>
            <div class="col-12">
              <input type="text" name="medical_levy" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="medical_levy1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">TUITION FEE</p>
            </div>
            <div class="col-12">
              <input type="text" name="tuition_fee" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="tuition_fee1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold" >INDUSTRIAL ATTACHMENT</p>
            </div>
            <div class="col-12">
              <input type="text" name="industrial_attachment" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="industrial_attachment1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">STUDENT ID</p>
            </div>
            <div class="col-12">
              <input type="text" name="student_id" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="student_id1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">EXIMANATION</p>
            </div>
            <div class="col-12">
              <input type="text" name="examination" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="examination1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">REGISTRATION FEE</p>
            </div>
            <div class="col-12">
              <input type="text" name="registration_fee" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="registration_fee1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">LIBRARY LEVY</p>
            </div>
            <div class="col-12">
              <input type="text" name="library_levy" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="library_levy1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">I.C.T LEVY</p>
            </div>
            <div class="col-12">
              <input type="text" name="ict_levy" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="ict_levy1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">ACTIVITY FEE</p>
            </div>
            <div class="col-12">
              <input type="text" name="activity_fee" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="activity_fee1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">STUDENT BENEVOLENT</p>
            </div>
            <div class="col-12">
              <input type="text" name="student_benevolent" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="student_benevolent1" class="form-control" value="00.00">
            </div>


            <div class="col-12">
              <p class="fw-semi-bold">KUCCPS PLACEMENT FEE</p>
            </div>
            <div class="col-12">
              <input type="text" name="kuccps_placement_fee" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="kuccps_placement_fee1" class="form-control" value="00.00">
            </div>

            <div class="col-12">
              <p class="fw-semi-bold">CUE LEVY</p>
            </div>
            <div class="col-12">
              <input type="text" name="cue_levy" class="form-control" value="00.00">
            </div>
            <div class="col-12">
              <input type="text" name="cue_levy1" class="form-control" value="00.00">
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
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
                    <a  href="#">View Semester Fee</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="block block-rounded">
      <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row justify-content-center">
                <div class="col-lg-11 space-y-0">
                   <form id="feeStructureForm" action="{{ route('courses.storeSemFee') }}" method="POST">
                    @csrf
                       <div class="row d-flex justify-content-end">
                           <div class="col-md-3 form-floating col">

                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-4 mb-4"><label class="fw-bold mb-0">FEE DESCRIPTION</label></div>
                           <div class="col-md-2 mb-4"><label class="fw-bold mb-0">AMOUNT PER SEM</label></div>
                           <div class="col-md-6 mb-4"><label class="fw-bold mb-0">EFFECTIVE SEMESTERS</label></div>
                       </div>

                           @foreach($votes as $key => $vote)
                           <div class="row votehead-item">
                               <div class="col-md-4 mb-2">
                                  {{ ++$key }} <input name="voteheads[]" type="hidden" value="{{ $vote->vote_id }} ">
                                   <label for=""> {{ $vote->vote_name }}</label>
                               </div>
                               <input type="hidden" name="course_code" value="{{ $course->course_code }}">
                               <div class="col-md-2 mb-2">
                                   <input value="{{ old('amount[]') }}" name="amount[]" type="text" class="form-control">
                               </div>
                               <div class="col-md-6 mb-2">
                                   @foreach($syllabus as $stage)
                                       <label>{{ $stage }}</label> <input name="semesters[]" type="checkbox" value="{{ $stage }}">
                                   @endforeach
                               </div>
                           </div>
                           @endforeach
                       <div class="row d-flex justify-content-center mt-4">
                           <div class="col-md-6 mb-4 form-floating">
                               <select id="attendance" name="attendance" class="form-control  text-uppercase" required>
                                   <option selected disabled> -- Select Mode -- </option>
                                   @foreach ($modes as $mode)
                                       <option value="{{ $mode->id }}">{{ $mode->attendance_code }}</option>
                                   @endforeach
                               </select>
                               <label class="mx-3">Course Mode of Study</label>
                           </div>
                       </div>
                       <input type="hidden" id="semFees" name="semesterFee" value="">
                       <div class="d-flex justify-content-center text-center mt-4">
                           <button onclick="return confirm('Only voteheads with selected amount and semester(s) will be included in the fees structure. Are sure you want to continue?')" id="feeStructureFormBtn" type="submit" class="btn btn-alt-success col-5" data-toggle="click-ripple"> Create Fee Structure </button>
                       </div>
                   </form>
                </div>
              </div>
            </div>
      </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#feeStructureFormBtn').click(function(e) {
            var attendanceSelect = $('[name="attendance"]');
            if (!attendanceSelect.val()) {
                e.preventDefault();
                attendanceSelect.addClass('is-invalid');
            }else {
                // Collect and process the form data
                var feeStructure = [];
                var formIsValid = false;

                $('.votehead-item').each(function () {
                    var votehead = {};
                    var voteheadInput = $(this).find('input[name="voteheads[]"]');
                    var amountInput = $(this).find('input[name="amount[]"]');
                    var semestersInputs = $(this).find('input[name="semesters[]"]:checked');


                    // Check if the amount is not null
                    if (amountInput.val() !== '' && semestersInputs.length > 0) {
                        votehead.votehead = voteheadInput.val();
                        votehead.amount = amountInput.val();

                        // Prepare semesters array
                        var semesters = [];
                        semestersInputs.each(function () {
                            semesters.push($(this).val());
                        });
                        votehead.semesters = semesters;

                        // Add the votehead to the feeStructure array
                        feeStructure.push(votehead);

                    }
                });

                if (feeStructure.length === 0){
                    formIsValid = false;
                }else {
                    formIsValid = true;
                }
                // Send the data to the controller if the form is valid
                if (formIsValid) {
                    // You can either send the data via AJAX or add it as a hidden input in the form
                    // Using AJAX:
                    $('#semFees').val(JSON.stringify(feeStructure))
                } else {
                    console.log(feeStructure)
                    e.preventDefault();
                    // Form is invalid, show an error message or take any other action
                    toastr.error('Oops! Ensure that fields are correctly filled', 'Incorrect Values');
                    console.log('Form is invalid. Some voteheads have null amounts.');
                }
            }
        });
    });
</script>

@extends('registrar::layouts.backend')

@section('content')
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="">

                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                          <a  href="showIntake">View Intakes</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
</div>

    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD Intake</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeIntake') }}" method="POST">
                    @csrf
                    <div class="row">

                      <div class="form-floating col-12 col-xl-12 mb-2">

                          <input type="date" class="form-control form-control-sm" id="intake_name_from" name="intake_name_from" placeholder="Intake From">
                          <label class="form-label">INTAKE FROM</label>
                        </div>
                        <br><br>
                        <div class="form-floating col-12 col-xl-12 mb-2">

                          <input type="date" class="form-control form-control-sm" id="intake_name_to" name="intake_name_to" placeholder="Intake To">
                          <label class="form-label">INTAKE TO</label>
                        </div>
                    </div>
                <BR>

                  <div>

                    <table class="table table-responsive table-striped py-0 table-borderless">
                      {{-- <input type="checkbox" name="course[]" id="course"/>Select All<br><br> --}}
                      @if (count($courses)>0)

                        @foreach ($courses as $course)
                          <tr>
                           <td>
                            <input type="checkbox" value="{{ $course->id }}" name="course[]">
                           </td>
                           <td>
                            <label for="course" class="form-label"> {{ $course->course_name }} </label>
                           </td>
                          </tr>
                        @endforeach

                        @else

                        <tr>
                          <span class="small"> no courses to select from </span>

                      @endif
                    </table>
                  </div><br>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Intake</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
{{-- <script>
$(document).ready(function(){
  var dtToday = new Date();
  var month = dtToday.getMonth() + 1;
  var day  =  dtToday.getDate();
  var year = dtToday.getFullYear();
  if(month < 10)
  month = '0' + month.toString();
  if(day < 10)
  day = '0' + day.toString();

  var maxDate = year + '-' +month+ '-' +day;
  $('#dateControl').attr('min',maxDate);
});
</script> --}}


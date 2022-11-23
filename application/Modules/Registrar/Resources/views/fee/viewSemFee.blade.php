@extends('registrar::layouts.backend')
@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="h5 fw-bold mb-0">
              <h5>SEMESTER FEE  ({{ $course->courseclm->course_code }})</h5>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Semester Fee</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                      View Semester Fee
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
          <div class="col-lg-12 space-y-2">
              <div class="col-lg-12">             
                  <div class="card-body">                  
                    <div class="table-responsive">
                      <table class="table table-bordered justify-content-center">
                        <span class="d-flex justify-content-end m-2">
                          <a class="btn btn-alt-info btn-sm" href="{{ route('courses.printFee', $id) }}">Print</a>
                      </span><br>
                        <thead>
                          <tr>
                            <th style="padding-bottom:30px"><b>FEE DESCRIPTION </b></th>
                            <th><b> SEMESTER I <br> (KSHS) </b></th>
                            <th><b> SEMESTER II <br> (KSHS) </b></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          @foreach($semesterI as $fee)
                   
                            <tr>
                                <td> {{ $fee->semVotehead->name }} </td>
                                <td class="text-end"> {{ number_format($fee->semesterI, 2) }}</td>
                                <td class="text-end"> {{ number_format($fee->semesterII, 2) }}</td>
                              </tr>
                          @endforeach
                                               
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
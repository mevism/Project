@extends('registrar::layouts.backend')


@section('content')
<script type="text/javascript">
  $(document).ready(function(){
    $('.btnPrint').printPage();
  });
</script>
<div class="content">
  <div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0">
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">   
                    <li class="breadcrumb-item " aria-current="page">
                      <a href="{{ route('courses.printFee') }}" class=" btn btn-alt-primary btnPrint">Print</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <!-- Inline -->
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-lg-10 space-y-2">
            <h4 style="text-align: center">TECHNICAL UNIVERSITY OF MOMBASA</h4>
            <hr style="color: green; font-weight:200;">
            <h5 style="padding-bottom:0px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; text-align:center;">Office of the Registrar (Academic Affairs)</h5>
            <h3 style="text-align: center"><b> FEES STRUCTURE FOR ALL KUCCPS DEGREE PROGRAMMES </b></h3>
            <div class="col-lg-12">             
                  <div class="card-body">                  
                    <div class="table-responsive">
                      <table class="table table-bordered justify-content-center">
                        <thead>
                          <tr>
                            <th style="padding-bottom:30px"><b>FEE DESCRIPTION </b></th>
                            <th><b> SEMESTER I <br> (KSHS) </b></th>
                            <th><b> SEMESTER II <br> (KSHS) </b></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                            <tr>
                                <td>  </td>
                                <td> </td>
                                <td></td>
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
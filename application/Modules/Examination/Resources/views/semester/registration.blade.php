@extends('examination::layouts.backend')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
  $(document).ready(function() {
      $('#example').DataTable( {
          responsive: true,
          order: [[2, 'asc']],
          rowGroup: {
              dataSrc: 2
          }
      } );
  } );
</script>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                       EXAMS
                    </h5>
                </div>
                
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
             <div class="col-12">
                <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                    <thead>
                        <th></th>
                        <th>Name</th>
                        <th>RegNo. </th>
                        <th>Cat </th>
                        <th>Exam </th>
                        <th>Total </th>
                        <th>Grade </th>
                        <th>status</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td style="text-transform: uppercase" >{{ ++$key }} </td>
                            <td nowrap="" style="text-transform: uppercase"class="fw-semibold fs-sm"> {{ $item->student->sname  }} {{ $item->student->fname }} {{ $item->student->mname  }}</td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm">{{ $item->student->reg_number }}</td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm"><input type="text" id="cat" class="input form-control form-control-sm"></td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm"><input type="text" id="exam" class="input form-control form-control-sm"></td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm"><input type="text" id="total" disabled class="form-control form-control-sm"></td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm" ><input type="text" id="grade" disabled class="form-control form-control-sm"></td>
                            <td style="text-transform: uppercase"class="fw-semibold fs-sm">
                            </td>
                        </tr>
                        @endforeach
                
                    </tbody>
                </table>
            </div>
        </div>
      </div>
          <!-- Dynamic Table Responsive -->
        </div>
        <!-- END Page Content -->

<script>
    $(".input").on('input', function(){
         
        var x = document.getElementById('cat').value;
        x = parseFloat(x);

        var y = document.getElementById('exam').value;
        y = parseFloat(y);

        var w = document.getElementById('total').value;
        if(x>30 || y>70 || w>100){
            alert('please enter correct values');
        }

        if(Number.isNaN(x))
        x = 0;
        else if(Number.isNaN(y))
        y = 0;
        
        w = x + y;
        document.getElementById('total').value = w;
       
       if(w >= 70){
        document.getElementById('grade').value = "A";
       }
       else if(w >= 60){
       document.getElementById('grade').value = "B";
       }else if(w >= 50){
       document.getElementById('grade').value = "C";
       }else if(w >= 40){
       document.getElementById('grade').value = "D";
       }else if(w < 40){
       document.getElementById('grade').value = "E";
       }
    });
</script>

@endsection


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
          order: [[0, 'asc']],
          rowGroup: {
              dataSrc: 0
          }
      } );
  } );
</script>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Exams
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Exams</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Exams
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
             <div class="col-12">
                <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                    <thead>
                        <th> # </th>
                        <th> Academic Semester </th>
                        <th> Academic Year </th>
                        <th> Action </th>
                    </thead>
                    <tbody>
                        @php
                         $i = 0;
                        @endphp
                        @foreach ($data as $items)
                           @foreach($items as $year => $item)
                               <tr>
                                   <td> {{ ++$i }} </td>
                                   <td> {{ $item->first()->academic_semester }} </td>
                                   <td> {{ $year }} </td>
                                   <td>
                                        <a class="btn btn-sm btn-outline-dark" href="{{ route('examination.semesterExams', ['year' => Crypt::encrypt($year), 'semester' => Crypt::encrypt($item->first()->academic_semester)]) }}"> Open </a>
                                   </td>
                               </tr>
                            @endforeach
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


@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        INTAKES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            View intakes
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
   {{-- <div class="car-body">
     <form action="">
       <div class="form-group">
         <input type="text" class="form-control typeahead" placeholder="search ..."/>
       </div>
     </form>
   </div> --}}
    <main id="main-container">
        <!-- Page Content -->

          <!-- Dynamic Table Responsive -->
          <div class="block block-rounded">

            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-12">
              <table class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
                <span class="d-flex justify-content-end">
                    <a class="btn btn-alt-info btn-sm" href="{{ route('courses.addIntake') }}">Create</a>
                </span>
                <thead>

                  <tr>
                    <th tyle="text-transform: uppercase">Intakes</th>
                    {{-- <th tyle="text-transform: uppercase">courses</th> --}}
                  </tr>

                </thead>
                <tbody>@foreach ($data as $intake)
                  <tr>
                    <td style="text-transform: uppercase" class="fw-semibold fs-sm">{{ Carbon\carbon::parse($intake->intake_from)->format('M-Y')}} - {{ Carbon\carbon::parse($intake->intake_to)->format('M-Y') }}</td>
                    <td style="text-transform: uppercase"class="fw-semibold fs-sm">{{ ($intake->course_id)}}</td>
                    <td>
                    @if ($intake->status === 0)
                    <a  class="btn btn-sm btn-alt-primary" href="{{ route('courses.editstatusIntake', $intake->id) }}">Pending</a>
                    @endif
                    @if ($intake->status === 1)
                    <a  class="btn btn-sm btn-alt-success" href="{{ route('courses.editstatusIntake', $intake->id) }}">Ongoing</a>
                    @endif
                    @if ($intake->status === 2)
                    <a  class="btn btn-sm btn-alt-info" href="{{ route('courses.editstatusIntake', $intake->id) }}">Expired</a>
                    @endif
                    @if ($intake->status === 3)
                    <a  class="btn btn-sm btn-alt-danger" href="{{ route('courses.editstatusIntake', $intake->id) }}">Suspended</a>
                    @endif
                     </td>
                    <td> <a class="btn btn-sm btn-alt-secondary" href="{{ route('courses.viewIntake', $intake->id) }}">view</a> </td>
                   {{-- <td> <a class="btn btn-sm btn-alt-info" href="{{ route('courses.editIntake', $intake->id) }}">edit</a> </td> --}}
                    <td> <a class="btn btn-sm btn-alt-danger" href="{{ route('courses.destroyIntake', $intake->id) }}">delete</a> </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
              {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>
          </div>
          <!-- Dynamic Table Responsive -->
        </div>
        <!-- END Page Content -->
    </main>
@endsection

<script>
  var path={{ route('courses.autocomplete') }};

  $('input.typeahead').typeahead({
    source: function(terms,process){
      return $.get(path,{terms:terms},function(datas){
        return process(datas);
      });
    }
  });
</script>

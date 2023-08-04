@extends('registrar::layouts.backend')
@section('content')
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <h6 class="h6 fw-bold mb-0 text-uppercase">
              {{ $course->course_code }} SEMESTER FEE
          </h6>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx text-uppercase" href="javascript:void(0)">Semester Fee</a>
                  </li>
                  <li class="breadcrumb-item text-uppercase" aria-current="page">
                      View Semester Fee
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
          <div class="col-lg-12 space-y-2">
              <div class="col-lg-12">
                  <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-end m-2">
                         <a class="btn btn-alt-secondary btn-sm m-2" href="{{ route('courses.printFee', $id) }}"><i class="fa fa-download"></i> download </a>
                      </div>
                        <table class="table table-borderless table-striped table-sm fs-sm">
                            <thead style="background: lightgrey !important;">
                            <th>#</th>
                            <th>DESCRIPTION</th>
                            @foreach ($semesters as $semester => $fees)
                                <th nowrap="" id="{{ $semester }}" style="font-size: 90% !important;" class="text-center"> YEAR {{ explode('.', $semester)[0] }} <br> SEMESTER {{ explode('.', $semester)[1] }} </th>
                            @endforeach
                            </thead>
                            <tbody>
                            @php $i = 1; @endphp
                            @foreach ($semesterFees as $votes => $fees)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ \Modules\Registrar\Entities\VoteHead::where('vote_id', $votes)->first()->vote_name }}</td>
                                    @foreach ($semesters as $semester => $_)
                                        <td style="text-align: end !important;">
                                            @if (isset($fees[$semester]))
                                                @foreach ($fees[$semester] as $fee)
                                                    {{ $fee->amount }}
                                                @endforeach
                                            @else
                                                --
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="background: gainsboro !important;">
                                <td>#</td>
                                <td>TOTALS</td>
                                @foreach ($semesters as $semester => $_)
                                    <td style="text-align: end !important;">
                                        @php $total = 0; @endphp
                                        @foreach ($semesterFees as $votes => $fees)
                                            @if (isset($fees[$semester]))
                                                @foreach ($fees[$semester] as $fee)
                                                    @php $total += $fee->amount @endphp
                                                @endforeach
                                            @endif
                                        @endforeach
                                        {{ $total }}
                                    </td>
                                @endforeach
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
@endsection

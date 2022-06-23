
@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        COURSES DETAILS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            View selected intake
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
    
 
    <main id="main-container">
        <!-- Page Content -->
        
          <!-- Dynamic Table Responsive -->
          <div class="block block-rounded">
           
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-12">
              <table class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
                <span class="d-flex justify-content-end">
              
                    
                  <tr>
                    <th>Course Code</th>
                    <th>Courses</th>
                    <th>Department</th>
                    <th>Level</th>
                    <th>Period</th>
                    <th>Requirements</th>
                    <th>Subject1</th>
                    <th>Subject2</th>
                    <th>Subject3</th>
                    <th>Subject4</th>
                  </tr>
                  
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    
                         @foreach ($course as $item)
                         <tr>
                            <td>{{ $item->course_code }}</td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item->department_id }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ $item->course_duration }}</td>
                            <td>{{ $item->course_requirements }}</td>
                            <td>{{ $item->subject1 }}</td>
                            <td>{{ $item->subject2 }}</td>
                            <td>{{ $item->subject3 }}</td>
                            <td>{{ $item->subject4 }}</td>
                    
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
    </main>
@endsection

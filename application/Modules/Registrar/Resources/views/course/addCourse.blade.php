@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="h3 fw-bold mb-2">

              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Courses</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showCourse">View Courses</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
        <div  class="block block-rounded">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD COURSE</h3>
            </div>
            <div class="block-content block-content-full">
                <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('courses.storeCourse') }}" method="POST">
                    @csrf
              <div class="row">

                <div class="col-lg-5 space-y-0">

                    <div class="form-floating col-12 col-xl-12 mb-4">
                      <select name="department" id="department" value="{{ old('department') }}" class="form-control form-control-sm text-uppercase">
                        <option selected disabled> Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                      @endforeach
                      <label class="form-label">DEPARTMENT</label>
                      </select>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                    <select name="level" id="level"value="{{ old('level') }}" class="form-control form-control-sm text-uppercase form-select">
                      <option disabled selected>Level of Study</option>
                      <option value="1">Certificate</option>
                      <option value="2">Diploma</option>
                      <option value="3">Degree</option>
                      <option value="4">Masters</option>
                      <option value="5">PhD</option>
                      <label class="form-label">LEVEL</label>
                    </select>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                      <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_name"value="{{ old('course_name') }}" name="course_name" placeholder="Course Name">
                      <label class="form-label">COURSE NAME</label>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_code" value="{{ old('course_code') }}"name="course_code" placeholder="Course Code">
                        <label class="form-label">COURSE CODE</label>
                      </div>
                      <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_duration" value="{{ old('course_duration') }}"name="course_duration" placeholder="Course Duration">
                        <label class="form-label">COURSE DURATION</label>
                      </div>
                      <div class="form-floating col-12 col-xl-12 mb-4">
                        <textarea class = "form-control form-control-sm text-uppercase" id="course_requirements" name="course_requirements" placeholder="Course Requirements">{{ old('course_requirements') }}</textarea>
                        <label class="form-label">COURSE REQUIREMENTS</label>
                      </div>
                </div>

                <div class=" col-lg-7 space-y-0">
                    <span class="h4 fw-semibold text-muted fs-sm">Add Course Cluster Subjects</span>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category m-1 fs-sm" name="school" id="category">
                                <option disabled selected> -- select group -- </option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"> {{ $school->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory m-1 fs-sm" multiple="multiple" name="subject[]" id="subcategory">
                                <option selected disabled>-- subject(s) -- </option>
                            </select>
                            <select name="grade1" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected disabled > -- select grade -- </option>
                                <option value="A"> A </option>
                                <option value="A-"> A- </option>
                                <option value="B+"> B+ </option>
                                <option value="B"> B </option>
                                <option value="B-"> B- </option>
                                <option value="C+"> C+ </option>
                                <option value="C"> C </option>
                                <option value="C-"> C- </option>
                                <option value="D+"> D+ </option>
                                <option value="D"> D </option>
                                <option value="D-"> D- </option>
                            </select>
                    </div>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category1 m-1 fs-sm" name="school" id="category1">
                                <option disabled selected> -- select group -- </option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"> {{ $school->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory1 m-1 fs-sm" multiple="multiple" name="subject1[]" id="subcategory1">
                                <option selected disabled>-- subject(s) -- </option>
                            </select>
                            <select name="grade2" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected disabled > -- select grade -- </option>
                                <option value="A"> A </option>
                                <option value="A-"> A- </option>
                                <option value="B+"> B+ </option>
                                <option value="B"> B </option>
                                <option value="B-"> B- </option>
                                <option value="C+"> C+ </option>
                                <option value="C"> C </option>
                                <option value="C-"> C- </option>
                                <option value="D+"> D+ </option>
                                <option value="D"> D </option>
                                <option value="D-"> D- </option>
                            </select>
                    </div>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category2 m-1 fs-sm" name="school" id="category2">
                                <option disabled selected> -- select group -- </option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"> {{ $school->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory2 m-1 fs-sm" multiple="multiple" name="subject2[]" id="subcategory2">
                                <option selected disabled>-- subject(s) -- </option>
                            </select>
                            <select name="grade3" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected disabled > -- select grade -- </option>
                                <option value="A"> A </option>
                                <option value="A-"> A- </option>
                                <option value="B+"> B+ </option>
                                <option value="B"> B </option>
                                <option value="B-"> B- </option>
                                <option value="C+"> C+ </option>
                                <option value="C"> C </option>
                                <option value="C-"> C- </option>
                                <option value="D+"> D+ </option>
                                <option value="D"> D </option>
                                <option value="D-"> D- </option>
                            </select>
                    </div>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category3 m-1 fs-sm" name="school" id="category3">
                                <option disabled selected> -- select group -- </option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"> {{ $school->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory3 m-1 fs-sm" multiple="multiple" name="subject3[]" id="subcategory3">
                                <option selected disabled>-- subject(s) -- </option>
                            </select>
                            <select name="grade4" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected disabled > -- select grade -- </option>
                                <option value="A"> A </option>
                                <option value="A-"> A- </option>
                                <option value="B+"> B+ </option>
                                <option value="B"> B </option>
                                <option value="B-"> B- </option>
                                <option value="C+"> C+ </option>
                                <option value="C"> C </option>
                                <option value="C-"> C- </option>
                                <option value="D+"> D+ </option>
                                <option value="D"> D </option>
                                <option value="D-"> D- </option>
                            </select>
                    </div>

                    <div class="d-flex justify-content-center m-2">
                        <div class="col-12 mb-4">
                            <label class="form-label">Offerd at: </label>
                            <div class="space-x-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="main" value="MAIN" @if(old('main') === 'campus') checked @endif >
                                    <label class="form-check-label">MAIN CAMPUS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="kwale" value="KWALE" @if(old('kwale') === 'kwale') checked @endif >
                                    <label class="form-check-label">KWALE CAMPUS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="lamu" value="LAMU" @if(old('lamu') === 'lamu') checked @endif>
                                    <label class="form-check-label">LAMU CAMPUS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center p-3">
                  <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Course</button>
                </div>
              </div>
                </form>
            </div>
        </div>
    </div>

        <script>
            $(document).ready(function (){
                $(document).on('change', '.category', function (){

                    var cat_id = $(this).val();

                    var div=$(this).parent();

                    var op = " ";

                    $.ajax({
                       type:"get",
                       url:"{{ route('courses.fetchDept') }}",
                        data:{'id':cat_id},
                        success:function (data){

                           op+='<option value="0" selected disabled> select department</option>';

                           for (var i=0;i<data.length;i++){
                               op+='<option value="'+data[i].name+'">'+data[i].name+'</input>';
                           }
                           div.find('#subcategory').html(" ");
                           div.find("#subcategory").append(op);
                        },
                        error:function (){

                        }

                    });
                });
            });

            $(document).ready(function (){
                $(document).on('change', '.category1', function (){

                    var cat_id = $(this).val();

                    var div=$(this).parent();

                    var op = " ";

                    $.ajax({
                        type:"get",
                        url:"{{ route('courses.fetchDept') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            op+='<option value="0" selected disabled> select department</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].name+'">'+data[i].name+'</input>';
                            }
                            div.find('#subcategory1').html(" ");
                            div.find("#subcategory1").append(op);
                        },
                        error:function (){

                        }

                    });
                });
            });

            $(document).ready(function (){
                $(document).on('change', '.category2', function (){

                    var cat_id = $(this).val();

                    var div=$(this).parent();

                    var op = " ";

                    $.ajax({
                        type:"get",
                        url:"{{ route('courses.fetchDept') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            op+='<option value="0" selected disabled> select department</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].name+'">'+data[i].name+'</input>';
                            }
                            div.find('#subcategory2').html(" ");
                            div.find("#subcategory2").append(op);
                        },
                        error:function (){

                        }

                    });
                });
            });

            $(document).ready(function (){
                $(document).on('change', '.category3', function (){

                    var cat_id = $(this).val();

                    var div=$(this).parent();

                    var op = " ";

                    $.ajax({
                        type:"get",
                        url:"{{ route('courses.fetchDept') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            op+='<option value="0" selected disabled> select department</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].name+'">'+data[i].name+'</input>';
                            }
                            div.find('#subcategory3').html(" ");
                            div.find("#subcategory3").append(op);
                        },
                        error:function (){

                        }

                    });
                });
            });

        </script>

{{--<script type = "text/javascript" >--}}
{{--    $(document).ready(function() {--}}
{{--        $('#category').on('change', function(e) {--}}
{{--            var cat_id = e.target.value;--}}
{{--            $.ajax({--}}
{{--                url: "{{ route('courses.fetchDept') }}",--}}
{{--                type: "POST",--}}
{{--                data: {--}}
{{--                    cat_id: cat_id--}}
{{--                },--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}

{{--                success: function(data) {--}}
{{--                    $('#subcategory').empty();--}}
{{--                    $.each(data.subcategories[0].subcategories, function(index, subcategory) {--}}
{{--                        $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');--}}
{{--                    })--}}
{{--                }--}}
{{--            })--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--    <script>--}}

{{--        $(document).ready(function() {--}}
{{--            $('#get-cluster-one').on('change', function(e) {--}}
{{--                var cat_id = e.target.value;--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('courses.fetchCluster') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        cat_id--}}
{{--                    },--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        $('#cluster1').empty();--}}
{{--                        data.subject.map( d => {--}}
{{--                            $('#cluster1').append(`--}}
{{--                                ${ (d.subject1) ? `<p><input type = 'checkbox' value = '${ d.subject1 }' name = 'subject_one_cluster_one' id = 'subject_one_cluster_one'> <span>${ d.subject1 }</span></p>` : "<br>"}--}}
{{--                                ${ (d.subject2) ? `<p><input type = 'checkbox' value = '${ d.subject2 }' name = 'subject_one_cluster_one' id = 'subject_two_cluster_one'> <span>${ d.subject2 }</span></p>` : "<br>"}--}}
{{--                                ${ (d.subject3) ? `<p><input type = 'checkbox' value = '${ d.subject3 }' name = 'subject_one_cluster_one' id = 'subject_three_cluster_one'> <span>${ d.subject3 }</span></p>` : "<br>"}--}}
{{--                                ${ (d.subject4) ? `<p><input type = 'checkbox' value = '${ d.subject4 }' name = 'subject_one_cluster_one' id = 'subject_four_cluster_one'> <span>${ d.subject4 }</span></p>` : "<br>"}--}}
{{--                                ${ (d.subject5) ? `<p><input type = 'checkbox' value = '${ d.subject5 }' name = 'subject_one_cluster_one' id = 'subject_five_cluster_one'> <span>${ d.subject5 }</span></p>` : "<br>"}--}}
{{--                            `);--}}
{{--                        })--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}

{{--            $('#get-cluster-two').on('change', function(e) {--}}
{{--                var cat_id = e.target.value;--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('courses.fetchCluster') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        cat_id--}}
{{--                    },--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        $('#cluster2').empty();--}}
{{--                        data.subject.map( d => {--}}
{{--                            $('#cluster2').append(`--}}
{{--                                ${ (d.subject1) ? `<input type = 'checkbox' value = '${ d.subject1 }' name = 'subject_one_cluster_two' id = 'subject_one_cluster_two'><p>${ d.subject1 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject2) ? `<input type = 'checkbox' value = '${ d.subject2 }' name = 'subject_two_cluster_two' id = 'subject_two_cluster_two'><p>${ d.subject2 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject3) ? `<input type = 'checkbox' value = '${ d.subject3 }' name = 'subject_three_cluster_two' id = 'subject_three_cluster_two'><p>${ d.subject3 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject4) ? `<input type = 'checkbox' value = '${ d.subject4 }' name = 'subject_four_cluster_two' id = 'subject_four_cluster_two'><p>${ d.subject4 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject5) ? `<input type = 'checkbox' value = '${ d.subject5 }' name = 'subject_five_cluster_two' id = 'subject_five_cluster_two'><p>${ d.subject5 }</p>` : "<br>"}--}}
{{--                            `);--}}
{{--                        })--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}

{{--            $('#get-cluster-three').on('change', function(e) {--}}
{{--                var cat_id = e.target.value;--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('courses.fetchCluster') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        cat_id--}}
{{--                    },--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        $('#cluster3').empty();--}}
{{--                        data.subject.map( d => {--}}
{{--                            $('#cluster3').append(`--}}
{{--                                ${ (d.subject1) ? `<input type = 'checkbox' value = '${ d.subject1 }' name = 'subject_one_cluster_three' id = 'subject_one_cluster_three'><p>${ d.subject1 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject2) ? `<input type = 'checkbox' value = '${ d.subject2 }' name = 'subject_two_cluster_three' id = 'subject_two_cluster_three'><p>${ d.subject2 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject3) ? `<input type = 'checkbox' value = '${ d.subject3 }' name = 'subject_three_cluster_three' id = 'subject_three_cluster_three'><p>${ d.subject3 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject4) ? `<input type = 'checkbox' value = '${ d.subject4 }' name = 'subject_four_cluster_three' id = 'subject_four_cluster_three'><p>${ d.subject4 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject5) ? `<input type = 'checkbox' value = '${ d.subject5 }' name = 'subject_five_cluster_three' id = 'subject_five_cluster_three'><p>${ d.subject5 }</p>` : "<br>"}--}}
{{--                            `);--}}
{{--                        })--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}

{{--            $('#get-cluster-four').on('change', function(e) {--}}
{{--                var cat_id = e.target.value;--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('courses.fetchCluster') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        cat_id--}}
{{--                    },--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        $('#cluster4').empty();--}}
{{--                        data.subject.map( d => {--}}
{{--                            $('#cluster4').append(`--}}
{{--                                ${ (d.subject1) ? `<input type = 'checkbox' value = '${ d.subject1 }' name = 'subject_one_cluster_four' id = 'subject_one_cluster_four'><p>${ d.subject1 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject2) ? `<input type = 'checkbox' value = '${ d.subject2 }' name = 'subject_two_cluster_four' id = 'subject_two_cluster_four'><p>${ d.subject2 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject3) ? `<input type = 'checkbox' value = '${ d.subject3 }' name = 'subject_three_cluster_four' id = 'subject_three_cluster_four'><p>${ d.subject3 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject4) ? `<input type = 'checkbox' value = '${ d.subject4 }' name = 'subject_four_cluster_four' id = 'subject_four_cluster_four'><p>${ d.subject4 }</p>` : "<br>"}--}}
{{--                                ${ (d.subject5) ? `<input type = 'checkbox' value = '${ d.subject5 }' name = 'subject_five_cluster_four' id = 'subject_five_cluster_four'><p>${ d.subject5 }</p>` : "<br>"}--}}

{{--                            `);--}}
{{--                        })--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection


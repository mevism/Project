@extends('registrar::layouts.backend')

@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
            <h4 class="h3 fw-bold mb-2 block-title">
                ADD COURSE
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
            <div class="block-content block-content-full">
                <form method="POST" action="{{ route('courses.storeCourse') }}">

                    @csrf
              <div class="row">
                <div class="col-lg-5 space-y-0">
                    <div class="form-floating col-12 col-xl-12 mb-4">
                      <select name="department" id="department" value="{{ old('department') }}" class="form-control form-control-sm text-uppercase fs-sm">
                        <option selected disabled> Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                      @endforeach
                      </select>
                        <label class="form-label">DEPARTMENT OFFERING</label>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                    <select name="level" id="level" value="{{ old('level') }}" class="form-control form-control-sm text-uppercase form-select fs-sm">
                      <option disabled selected>Level of Study</option>
                      @foreach($levels as $level)
                          <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                        <label class="form-label">COURSE LEVEL</label>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                      <input type = "text" class = "form-control form-control-sm text-uppercase fs-sm" id = "course_name"value="{{ old('course_name') }}" name="course_name" placeholder="Course Name">
                      <label class="form-label">COURSE NAME</label>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase fs-sm" id = "course_code" value="{{ old('course_code') }}"name="course_code" placeholder="Course Code">
                        <label class="form-label">COURSE CODE</label>
                      </div>
                      <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase fs-sm" id = "course_duration" value="{{ old('course_duration') }}"name="course_duration" placeholder="Course Duration">
                        <label class="form-label">COURSE DURATION</label>
                      </div>
                      <div class="form-floating col-12 col-xl-12 mb-4">
                        <textarea class = "form-control form-control-sm text-uppercase fs-sm" id="course_requirements" name="course_requirements" placeholder="Course Requirements">{{ old('course_requirements') }}</textarea>
                        <label class="form-label">COURSE REQUIREMENTS</label>
                      </div>
                     </div>
                <div class=" col-lg-7 space-y-0">
                    <span class="h4 fw-semibold text-muted fs-sm">Add Course Cluster Subjects</span>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category m-1 fs-sm" name="school" id="category">
                                <option disabled selected> -- select group -- </option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->group_id }}"> {{ $group->name }}</option>
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
                                @foreach ($groups as $group)
                                    <option value="{{ $group->group_id }}"> {{ $group->name }}</option>
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
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->group_id }}"> {{ $group->name }}</option>
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
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->group_id }}"> {{ $group->name }}</option>
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

                    <div class="form-floating">
                        <select class="form-control form-control-sm text-uppercase category3 m-1 fs-sm" name="cluster_group" id="cluster">
                            <option class="text-center" disabled selected> -- select course cluster group -- </option>
                            @foreach($clusters as $cluster)
                                <option value="{{ $cluster->group }}">{{ $cluster->group }}</option>
                            @endforeach
                        </select>
                        <label>CLUSTER GROUPS </label>
                        <small class="text-danger">All undergrad courses must have a cluster group</small>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function (){
                $(document).on('change', '.category', function (){

                    var cat_id = $(this).val();

                    var div=$(this).parent();

                    var op = " ";

                    $.ajax({
                       type:"get",
                       url:"{{ route('courses.fetchSubjects') }}",
                        data:{'id':cat_id},
                        success:function (data){

                           console.log(data);

                           op+='<option value="0" selected disabled> select subject</option>';

                           for (var i=0;i<data.length;i++){
                               op+='<option value="'+data[i].subject+'">'+data[i].subject+'</input>';
                           }
                           div.find('#subcategory').html(" ");
                           div.find("#subcategory").append(op);

                           console.log(op);
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
                        url:"{{ route('courses.fetchSubjects') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            console.log(data);

                            op+='<option value="0" selected disabled> select subject</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].subject+'">'+data[i].subject+'</input>';
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
                        url:"{{ route('courses.fetchSubjects') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            op+='<option value="0" selected disabled> select subject</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].subject+'">'+data[i].subject+'</input>';
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
                        url:"{{ route('courses.fetchSubjects') }}",
                        data:{'id':cat_id},
                        success:function (data){

                            op+='<option value="0" selected disabled> select subject</option>';

                            for (var i=0;i<data.length;i++){
                                op+='<option value="'+data[i].subject+'">'+data[i].subject+'</input>';
                            }
                            div.find('#subcategory3').html(" ");
                            div.find("#subcategory3").append(op);
                        },
                        error:function (){

                        }

                    });
                });
            });

            $(document).ready(function() {
                var $cluster = $("#cluster");
                var $level = $("#level");

                $cluster.prop("disabled", true);

                $level.on("change", function() {

                    if ($level.val() === '3') {

                        $cluster.prop("disabled", false);
                    } else {
                        $cluster.prop("disabled", true);
                    }
                });
            });


        </script>
@endsection


<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
            <h4 class="h3 fw-bold mb-2 block-title">
                EDIT COURSE
              </h4>
          </div>

      </div>
  </div>
</div>
    <div class="content">
        <div  class="block block-rounded">
            <div class="block-header block-header-default">
            </div>
            <div class="block-content block-content-full">
                <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.updateCourse',$data->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
              <div class="row">
                <div class="col-lg-5 space-y-0">

                    <div class="form-floating col-12 col-xl-12 mb-4">
                      <select name="department" id="department"  class="form-control form-control-sm text-uppercase">
                        <option selected value="<?php echo e($data->department_id); ?>"> <?php echo e($data->getCourseDept->name); ?></option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <label class="form-label">DEPARTMENT</label>
                      </select>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                    <select name="level" id="level" class="form-control form-control-sm text-uppercase form-select">
                      <option <?php if($data->level == 1): ?> selected <?php endif; ?> value="1"> Certificate </option>
                      <option <?php if($data->level == 2): ?> selected <?php endif; ?> value="2"> Diploma </option>
                      <option <?php if($data->level == 3): ?> selected <?php endif; ?> value="3"> Degree </option>
                      <option <?php if($data->level == 4): ?> selected <?php endif; ?> value="4"> Masters </option>
                      <option <?php if($data->level == 5): ?> selected <?php endif; ?> value="5"> PhD </option>
                      <label class="form-label">LEVEL</label>
                    </select>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                      <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_name" value="<?php echo e($data->course_name); ?>" name="course_name" placeholder="Course Name">
                      <label class="form-label">COURSE NAME</label>
                    </div>
                    <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_code" value="<?php echo e($data->course_code); ?>" name="course_code" placeholder="Course Code">
                        <label class="form-label">COURSE CODE</label>
                      </div>
                      <div class="form-floating  col-12 col-xl-12 mb-4">
                        <input type = "text" class = "form-control form-control-sm text-uppercase" id = "course_duration" value="<?php echo e($data->courseRequirements->course_duration); ?> " name="course_duration" placeholder="Course Duration">
                        <label class="form-label">COURSE DURATION</label>
                      </div>
                      <div class="form-floating col-12 col-xl-12 mb-4">
                        <textarea class = "form-control form-control-sm text-uppercase" id="course_requirements" name="course_requirements" placeholder="Course Requirements"> <?php echo e($data->courseRequirements->course_requirements); ?> </textarea>
                        <label class="form-label">COURSE REQUIREMENTS</label>
                      </div>
                     </div>
                <div class=" col-lg-7 space-y-0">
                    <span class="h4 fw-semibold text-muted fs-sm">Add Course Cluster Subjects</span>
                    <div class="d-flex justify-content-center col-sm-12">
                        <select class="form-control form-control-sm text-uppercase category m-1 fs-sm" name="school" id="category">
                                <option disabled selected> -- select group -- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory m-1 fs-sm" multiple="multiple" name="subject[]" id="subcategory">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject1)[0]); ?>"><?php echo e(explode(' ', $data->courseRequirements->subject1)[0]); ?> </option>
                            </select>
                            <select name="grade1" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject1)[1]); ?>" > <?php echo e(explode(' ', $data->courseRequirements->subject1)[1]); ?> </option>
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
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory1 m-1 fs-sm" multiple="multiple" name="subject1[]" id="subcategory1">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject2)[0]); ?>"><?php echo e(explode(' ', $data->courseRequirements->subject2)[0]); ?> </option>
                            </select>
                            <select name="grade2" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject2)[1]); ?>" > <?php echo e(explode(' ', $data->courseRequirements->subject2)[1]); ?> </option>
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
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory2 m-1 fs-sm" multiple="multiple" name="subject2[]" id="subcategory2">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject3)[0]); ?>"><?php echo e(explode(' ', $data->courseRequirements->subject3)[0]); ?> </option>
                            </select>
                            <select name="grade3" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject3)[1]); ?>" ><?php echo e(explode(' ', $data->courseRequirements->subject3)[1]); ?> </option>
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
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-control form-control-sm text-uppercase subcategory3 m-1 fs-sm" multiple="multiple" name="subject3[]" id="subcategory3">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject4)[0]); ?>"><?php echo e(explode(' ', $data->courseRequirements->subject4)[0]); ?> </option>
                            </select>
                            <select name="grade4" class="dept form-control form-control-md text-uppercase m-1 fs-sm">
                                <option selected value="<?php echo e(explode(' ', $data->courseRequirements->subject4)[1]); ?>" > <?php echo e(explode(' ', $data->courseRequirements->subject4)[1]); ?></option>
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

                </div>
                <div class="col-12 text-center p-3">
                  <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Course</button>
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
                       url:"<?php echo e(route('courses.fetchSubjects')); ?>",
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
                        url:"<?php echo e(route('courses.fetchSubjects')); ?>",
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
                        url:"<?php echo e(route('courses.fetchSubjects')); ?>",
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
                        url:"<?php echo e(route('courses.fetchSubjects')); ?>",
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

        </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Registrar/Resources/views/course/editCourse.blade.php ENDPATH**/ ?>


<?php $__env->startSection('content'); ?> 

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
              <div class="row">
                 
                <div class="col-lg-8 space-y-0">
                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.storeCourse')); ?>" method="POST">
                    <?php echo csrf_field(); ?> 
                                   
                    <div class="col-12 col-xl-12">
                      <select name="school" id="school" value="<?php echo e(old('school')); ?>" class="form-control form-control-alt text-uppercase">
                        <option selected disabled> Select School</option>
                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($school->name); ?>"><?php echo e($school->name); ?></option>        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="col-12 col-xl-12">
                      <select name="department" id="department" value="<?php echo e(old('department')); ?>" class="form-control form-control-alt text-uppercase">
                        <option selected disabled> Select Department</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($department->name); ?>"><?php echo e($department->name); ?></option>        
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="col-12 col-xl-12">
                    <select name="level" id="level"value="<?php echo e(old('level')); ?>" class="form-control form-control-alt text-uppercase form-select">
                      <option disabled selected>Level of Study</option>
                      <option value="1">Certificate</option>
                      <option value="2">Diploma</option>
                      <option value="3">Degree</option>
                      <option value="4">Masters</option>
                      <option value="5">PhD</option>
                    </select>
                    </div>
                    <div class="col-12 col-xl-12">
                      <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_name"value="<?php echo e(old('course_name')); ?>" name="course_name" placeholder="Course Name">
                    </div>
                    <div class="col-12 col-xl-12">
                        <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_code" value="<?php echo e(old('course_code')); ?>"name="course_code" placeholder="Course Code">
                      </div>
                      <div class="col-12 col-xl-12">
                        <input type = "text" class = "form-control form-control-alt text-uppercase" id = "course_duration" value="<?php echo e(old('course_duration')); ?>"name="course_duration" placeholder="Course Duration">
                      </div>
                      <div class="col-12 col-xl-12">
                        <textarea class = "form-control form-control-alt text-uppercase" id="course_requirements" name="course_requirements" placeholder="Course Requirements"><?php echo e(old('course_requirements')); ?></textarea>
                        
                      </div>
                </div>
                
                <div class="col-lg-4">                
                    <div class="col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('subject1')); ?>" class="form-control form-control-alt text-uppercase" id="subject1" name="subject1" placeholder="subject1">
                    </div>
                    <br>
                    <div class="col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('subject2')); ?>"class="form-control form-control-alt text-uppercase" id="subject2" name="subject2" placeholder="subject2">
                    </div><br>
                   
                    <div class="col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('subject3')); ?>"class="form-control form-control-alt text-uppercase" id="subject3" name="subject3" placeholder="One Humanity">
                    </div><br>
                   

                    <div class="col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('subject4')); ?>"class="form-control form-control-alt text-uppercase" id="subject4" name="subject4" placeholder="one science">
                    </div><br>

                    <p class="p-2">
                      
                      <b>KEY:</b>  <br>
                      Format to key in cluster subjects <br>
                     <span class="small">
                        MAT B+ <br>
                        ENG A-
                      </span>

                    </p>
                </div>
                <div class="col-12 text-center p-3">
                  <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Course</button>
                </div>
              </form>
              </div>
            </div>
          </div>
    </div> 
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Registrar\Resources/views/course/addCourse.blade.php ENDPATH**/ ?>
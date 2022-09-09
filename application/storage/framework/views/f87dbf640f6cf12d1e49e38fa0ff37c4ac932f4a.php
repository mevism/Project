

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
          <div class="flex-grow-1">
              <h4 class="h3 fw-bold mb-2">
                  Edit Class
              </h4>
          </div>
      </div>
  </div>
</div>
    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">Edit Class <span class="fw-bold"><?php echo e($data->name); ?></span> </h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.updateClasses',$data->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                   <div class="form-floating col-12 col-xl-12">
                      <select name="attendance" id="attendance"class="form-control form-control-alt text-uppercase">

                        <option selected value="<?php echo e($data->attendance_id); ?>"><?php echo e($data->attendance_id); ?> </option>

                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($attendance->attendance_name); ?>"><?php echo e($attendance->attendance_name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <input type="hidden" name="attendance_code" value="<?php echo e($attendance->attendance_code); ?>">
                          <label class="form-label">ATTENDANCE NAME</label>
                      </select>
                    </div>
                   <div class="form-floating col-12 col-xl-12">
                      <select name="intake_from" id="intake_from" class="form-control form-control-alt" required>
                        <option selected value="<?php echo e($data->intake_from); ?>"> <?php echo e($data->intake_from); ?> </option>
                        <?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($intake->intake_from); ?>"><?php echo e(Carbon\Carbon::parse($intake->intake_from)->format('M-Y')); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <label class="form-label">INTAKE NAME</label>
                      </select>
                    </div>

                    

                   <div class="form-floating col-12 col-xl-12">
                      <select name="course" class="form-control form-control-alt" required>
                          <option value="<?php echo e($data->course_id); ?>" selected><?php echo e($data->course_id); ?></option>
                          <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                          <option value="<?php echo e($course->course_name); ?>"><?php echo e($course->course_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <input type="hidden" name="course_code" value="<?php echo e($course->course_code); ?>">
                              <label class="form-label">COURSE NAME</label>
                      </select>
                    </div>
                    
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Update Class</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Registrar\Resources/views/class/editClasses.blade.php ENDPATH**/ ?>
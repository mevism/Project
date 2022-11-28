

<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="h6 fw-bold mb-0">
                  ADD COURSE FEE STRUCTURE
              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Semester Fee</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showSemFee">View Semester Fee</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div class="block block-rounded col-md-9 col-lg-8 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form action="<?php echo e(route('courses.storeSemFee')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                       <div class="row row-cols-sm-3 g-2">
                           <div class="form-floating mb-2">
                               <select name="course" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Course -- </option>
                                   <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_name); ?></option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </select>
                           </div>

                           <div class="form-floating mb-2">
                               <select name="level" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Level --</option>
                                   <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($level->id); ?>"><?php echo e($level->name); ?></option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   
                               </select>
                           </div>

                           <div class="form-floating col">
                               <select name="attendance" class="form-control  text-uppercase">
                                   <option selected disabled> -- Select Mode -- </option>
                                   <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($mode->id); ?>"><?php echo e($mode->attendance_code); ?></option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </select>
                           </div>

                           <label class="fw-bold mb-2 mt-4">FEE DESCRIPTION</label>
                           <label class="fw-bold mb-2 mt-4">SEMESTER I (KSHS.)</label>
                           <label class="fw-bold mb-2 mt-4">SEMESTER II (KSHS.)</label>

                           <?php $__currentLoopData = $votes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="mb-4">
                               <input name="voteheads[]" type="hidden" value="<?php echo e($vote->id); ?> ">
                               <label for=""> <?php echo e($vote->name); ?></label>
                           </div>
                           <div class="mb-4">
                               <input name="semester1[]" type="text" class="form-control">
                           </div>
                           <div class="mb-4">
                               <input name="semester2[]" type="text" class="form-control">
                           </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                       </div>
                       <div class="d-flex justify-content-center text-center mt-4">
                           <button class="btn btn-alt-success col-5" data-toggle="click-ripple" type="submit"> Create Fee Structure </button>
                       </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/fee/semFee.blade.php ENDPATH**/ ?>



<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0" style="text-align: center">
                       IMPORT KUCCPS STUDENTS
                    </h5>
                </div>
             
            </div>
        </div>
    </div>

    <div class="content">
    <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
        <div class="block-header block-header-default">
            <h3 class="block-title" style="text-align: center">Import </h3>
          </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12 space-y-0">

                <?php if(count($new) == 0): ?>
                    <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.importkuccps')); ?>" method="post" enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>
                    <div class="col-12 col-xl-12">
                        <label class="mb-2 fw-bold " for="">Intake</label>
                        <select name="intake" id="intake" value="" class="form-control form-control-alt text-uppercase">
                          <option selected disabled> Select Intake</option>
                          <?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($intake->id); ?>"><?php echo e(Carbon\carbon::parse($intake->intake_from)->format('M')); ?> - <?php echo e(Carbon\carbon::parse($intake->intake_to)->format('M Y')); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>

                    <div class="col-12 col-xl-12">
                         <label class="mb-2 fw-bold">File Import</label>
                         <input type="file" name="excel_file" class="form-control">
                    </div>
                    <br>
                    <div class="col-12 col-xl-12">
                         <button type="submit" class="btn btn-alt-success mb-3">Import </button>
                    </div>
                  

                </form>
                    <?php else: ?>
            </div>
                <div class="d-flex justify-content-center">

                    <span class="text-success"> You have imported <?php echo e(count($new)); ?> new students </span>

                </div>
                  <div class="d-flex justify-content-center">

                     <a class="btn btn-sm btn-alt-success col-md-4 mt-4" onclick="return confirm('Do you want to generate letters? The process can not be reversed!!!')" href="<?php echo e(route('courses.accepted')); ?>" data-toggle="click-ripple"> Generate Admission Letters </a>

                     </div>
                <?php endif; ?>
                  </div>
        </div>
    </div>
    </div></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/offer/kuccps.blade.php ENDPATH**/ ?>
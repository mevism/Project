
<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="h5 fw-bold mb-0">
              <h5>SEMESTER FEE  (<?php echo e($course->courseclm->course_code); ?>)</h5>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Semester Fee</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                      View Semester Fee
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
 
<div class="content">
    <!-- Inline -->
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-lg-12 space-y-2">
              <div class="col-lg-12">             
                  <div class="card-body">                  
                    <div class="table-responsive">
                      <table class="table table-bordered justify-content-center">
                        <span class="d-flex justify-content-end m-2">
                          
                         <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('courses.printFee', ['id'=>Crypt::encrypt($id)])); ?>">Print</a>
                      </span><br>
                        <thead>
                          <tr>
                            <th style="padding-bottom:30px"><b>FEE DESCRIPTION </b></th>
                            <th><b> SEMESTER I <br> (KSHS) </b></th>
                            <th><b> SEMESTER II <br> (KSHS) </b></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          <?php $__currentLoopData = $semesterI; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                            <tr>
                                <td> <?php echo e($fee->semVotehead->name); ?> </td>
                                <td class="text-end"> <?php echo e(number_format($fee->semesterI, 2)); ?></td>
                                <td class="text-end"> <?php echo e(number_format($fee->semesterII, 2)); ?></td>
                              </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                               
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/fee/viewSemFee.blade.php ENDPATH**/ ?>
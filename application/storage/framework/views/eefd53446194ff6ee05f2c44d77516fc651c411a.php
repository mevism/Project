<?php $__env->startSection('content'); ?> 
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="">
                    
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                          <a  href="showIntake">View Intakes</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
</div>

    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD Intake</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.storeIntake')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                      <div class="col-12">                
                      </div>
                        <div  class="col-12">
                          <label for="intake_name">From:</label>
                          <input type="date" class="form-control form-control-alt" id="intake_name_from" name="intake_name_from" placeholder="Intake From">
                          
                        </div>
                        <br>
                        <div class="col-12">
                          <label for="intake_name">To:</label>
                          <input type="date" class="form-control form-control-alt" id="intake_name_to" name="intake_name_to" placeholder="Intake To">
                          
                        </div>
                    </div>
                
                    
                  <div>
                   
                    <table class="table table-responsive table-striped py-0 table-borderless">
                      
                      <?php if(count($courses)>0): ?>

                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                           <td>
                            <input type="checkbox" value="<?php echo e($course->id); ?>" name="course[]">
                           </td>
                           <td>
                            <label for="course" class="form-label"> <?php echo e($course->course_name); ?> </label>
                           </td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php else: ?>

                        <tr>
                          <span class="small"> no courses to select from </span>
                        
                      <?php endif; ?>          
                    </table>
                  </div><br>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Intake</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Finale/application/Modules/Registrar/Resources/views/intake/addIntake.blade.php ENDPATH**/ ?>
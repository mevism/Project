

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
                        
                    </ol>
                </nav>
            </div>
        </div>
</div>

    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">Change Status</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-8 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.statusIntake',$data->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                      <div class="col-12">                
                      </div>
                        <div  class="col-12">
                          <input type="hidden" class="form-control form-control-alt" id="intake_name_from" name="intake_name_from" placeholder="Intake From">
                        </div>
                        <br>
                        <div class="col-12">
                         <select name="status"  class="form-control form-control-alt">
                             <option selected disabled value="" class="form-select">
                              <?php if($data->status === 0): ?>
                                pending
                                <?php elseif($data->status === 1): ?>
                                Active
                                <?php elseif($data->status  === 2): ?>
                                Inactive
                                <?php else: ?>
                                Suspended
                              <?php endif; ?>

                             </option>
                             <option value="2">Expired</option>
                             <option value="1">Active</option>
                             <option value="0">Pending</option>
                             <option value="3">Suspended</option>
                         </select>
                        </div>
                    </div>
                    
                  <div>
                  
                  </div><br>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Submit</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Registrar\Resources/views/intake/editstatusIntake.blade.php ENDPATH**/ ?>
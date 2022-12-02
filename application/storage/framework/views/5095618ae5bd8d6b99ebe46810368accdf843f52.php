<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
          <h6 class="block-title">EDIT VOTEHEAD</h6>
        </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Voteheads</a>
                  </li>
                  
              </ol>
          </nav>
      </div>
  </div>
</div>
<div class="content">
  <div  class="block block-rounded col-md-12 col-lg-12 col-xl-12">
        <div class="block-content block-content-full">
          <div class="row">
              <div class="d-flex justify-content-center">
                <div class="col-lg-6 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.updateVotehead',$data->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="<?php echo e($data->name); ?>"  class="form-control form-control-alt text-uppercase" id="name" name="name" placeholder="Name ">
                      <label class="form-label">NAME</label>
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Edit Votehead</button>
                    </div>
                  </form>
                </div>
              </div>
              </div>
            </div>
          </div>
    </div> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Registrar/Resources/views/fee/editVotehead.blade.php ENDPATH**/ ?>
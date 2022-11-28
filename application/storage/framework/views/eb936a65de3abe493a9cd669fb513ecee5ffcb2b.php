

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <h6 class="h6 fw-bold mb-0">
                ADD EVENT
            </h6>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Event</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showEvent">View Event</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>

    <div class="content">
      <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
            <div class="block-content block-content-full">
              <div class="row">
                  <div class="d-flex justify-content-center">
                        <div class="col-lg-6 space-y-0">

                   <form action="<?php echo e(route('courses.storeEvent')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('name')); ?>"  class="form-control form-control-alt text-uppercase" id="name" name="name" placeholder="School Name">
                      <label class="form-label">EVENT</label>
                    </div>

                    <div class="col-12 text-center p-3">
                      <button type="submit"  class="btn btn-alt-success" data-toggle="click-ripple">Create Event</button>
                    </div>
                  </form>

                </div>
                  </div>
              </div>
            </div>
          </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/events/addEvent.blade.php ENDPATH**/ ?>
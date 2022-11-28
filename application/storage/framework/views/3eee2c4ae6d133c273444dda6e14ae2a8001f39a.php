

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1 text-uppercase">
                    <h6 class="h6 fw-bold mb-0">EDIT <?php echo e(Carbon\Carbon::parse($data->intake_from)->format('MY')); ?> STATUS</h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update Intake Status
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
                          <form action="<?php echo e(route('courses.statusIntake', ['id' => Crypt::encrypt($data->id)])); ?>" method="POST">
                              <?php echo csrf_field(); ?>
                              <?php echo method_field('PUT'); ?>
                              <div class="row">
                                  <div class="col-12">
                                      <select name="status"  class="form-control form-select-lg form-control-alt">
                                          <option <?php if($data->status == 0): ?> selected <?php endif; ?> value="0">Pending</option>
                                          <option <?php if($data->status == 1): ?> selected <?php endif; ?> value="1">Active</option>
                                          <option <?php if($data->status == 2): ?> selected <?php endif; ?> value="2">Expired</option>
                                          <option <?php if($data->status == 3): ?> selected <?php endif; ?> value="3">Suspended</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-12 text-center p-3">
                                  <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Submit</button>
                              </div>
                          </form>
                      </div>
                  </div>
            </div>
      </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/intake/editstatusIntake.blade.php ENDPATH**/ ?>
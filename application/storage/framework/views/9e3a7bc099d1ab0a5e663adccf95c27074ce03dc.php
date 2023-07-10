
<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-application')): ?>

                <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('cod.applications')); ?>">
                        <div class="block-content block-content-full">
                            <div class="fs-sm fw-semibold text-uppercase text-muted">Pending Applications </div>
                            <div class="fs-2 fw-normal text-dark">
                                <?php echo e($apps); ?>

                            </div>
                        </div>
                    </a>
                </div>

            <?php endif; ?>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('cod.Admissions')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Pending Admissions </div>
                        <div class="fs-2 fw-normal text-dark">
                            <?php echo e($admissions); ?>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Department Classes </div>
                        <div class="fs-2 fw-normal text-dark">
                            <?php echo e($admissions); ?>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- END Stats -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/COD\Resources/views/COD/index.blade.php ENDPATH**/ ?>
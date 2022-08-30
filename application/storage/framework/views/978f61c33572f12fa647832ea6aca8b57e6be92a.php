<?php $__env->startSection('content'); ?>
    <!-- Page Content -->
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('applicant.courses')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Courses on offer</div>
                        <div class="fs-2 fw-normal text-dark">
                            <?php echo e(count($courses)); ?>



                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('applicant.course')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Courses</div>
                        <div class="fs-2 fw-normal text-dark"><?php echo e($mycourses); ?></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" disabled=" " href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Notifications</div>
                        <div class="fs-2 fw-normal text-dark">6 <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New</span></span> </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('applicant.profile')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">My Profile</div>
                        <div class="fs-2 fw-normal text-dark"><i class="fa fa-user-gear"></i> </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>
    <!-- END Page Content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Application/Resources/views/applicant/home.blade.php ENDPATH**/ ?>
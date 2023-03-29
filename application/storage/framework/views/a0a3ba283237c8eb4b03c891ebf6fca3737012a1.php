
<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Workload</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-tasks mt-2" style="font-size: 140% !important;"></i>
                            
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">Student Marks</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-award mt-2" style="font-size: 140% !important;"></i>
                            
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" disabled=" " href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Qualification</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-user-graduate mt-2" style="font-size: 140% !important;"></i>
                            
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="#">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-success">My Profile</div>
                        <div class="fs-2 fw-normal" style="color: #fd7e14 !important;">
                            <i class="fa fa-user-gear mt-2" style="font-size: 140% !important;"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Lecturer\Resources/views/index.blade.php ENDPATH**/ ?>

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row  align-items-sm-center">
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                    Dashboard | Registrar
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Registrar</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" >
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <!-- Page Content -->
    <div class="content">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('courses.offer')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Courses on offer</div>
                        <div class="fs-2 fw-normal text-dark">
                            <?php echo e($courses); ?>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('courses.applications')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Applications</div>
                        <div class="fs-2 fw-normal text-dark"><?php echo e($applications); ?> <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New </span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('courses.admissions')); ?>">
                    <div class="block-content block-content-full">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Admissions</div>
                        <div class="fs-2 fw-normal text-dark"><?php echo e($admissions); ?> <span class="badge rounded-pill bg-info" style="font-size: x-small !important;"><i class="fa fa-fw fa-message"></i> New </span></div>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('courses.profile')); ?>">
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

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\resources\views/admin/index.blade.php ENDPATH**/ ?>
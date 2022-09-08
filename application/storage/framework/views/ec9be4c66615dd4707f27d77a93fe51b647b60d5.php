<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h5 fw-bold mb-2">
                    HOME
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <!-- Stats -->
    <div class="row">
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('units')); ?>" id = 'host-student'>
                <div class="block-content block-content-full">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Enroll Units</div>
                    <div class="fs-2 fw-normal text-dark">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('fee')); ?>" id = 'host-student'>
                <div class="block-content block-content-full">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Fee Balance</div>
                    <div class="fs-2 fw-normal text-dark"><i class="fa fa-coins"></i> </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('hostel')); ?>" id = 'host-student'>
                <div class="block-content block-content-full">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Book Hostel</div>
                    <div class="fs-2 fw-normal text-dark"><i class="fa fa-hotel"></i> </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-start border-primary border-4" href="<?php echo e(route('change_course')); ?>" id = 'host-student'>
                <div class="block-content block-content-full">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Change Course</div>
                    <div class="fs-2 fw-normal text-dark"><i class="fa fa-book"></i> </div>
                </div>
            </a>
        </div>
    </div>
    <!-- END Stats -->
</div>
<div id="remind_profile"></div>
<div class="content-force-student">
    <div class = 'profile-img'>
        <img src = '<?php echo e(asset('Images/profile.svg')); ?>' id = 'profile-set-image' alt = 'Profile Image'>
        <input type = 'file' id = 'input-profile'>
        <button id = 'actual-input' class = 'btn btn-sm btn-alt-info'>Update Image</button>
    </div>
    <div id = 'student_profile'></div>
</div>
<!-- END Page Content -->
<script src="<?php echo e(url("js/build.js")); ?>"></script>
<script>
    plotProfile();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\project\application\Modules/Student\Resources/views/student/index.blade.php ENDPATH**/ ?>
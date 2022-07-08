
<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        View selected course
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            view
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <!-- Developer Plan -->
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-header">
                        <h2 class="block-title fw-bold"><?php echo e($course->course_name); ?> | <?php echo e($course->course_duration); ?> years</h2>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="py-2">
                            <p class="mb-2"><?php echo e($course->course_requirements); ?></p>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="h5 fw-bold mb-2">Cluster Subjects </div>
                        <div class="fs-sm py-2">
                            <div class="row">
                                <div class="col-md-6"> Subject 1</div>
                                <div class="col-md-6"><?php echo e($course->subject1); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> Subject 2 </div>
                                <div class="col-md-6"><?php echo e($course->subject2); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Subject 3 </div>
                                <div class="col-md-6"><?php echo e($course->subject3); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Subject 4 </div>
                                <div class="col-md-6"><?php echo e($course->subject4); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-body-light text-center">
                        <a href="<?php echo e(route('application.apply', $course->id)); ?>" class="btn btn-alt-success btn-sm" data-toggle="click-ripple">Apply now</a>
                    </div>
                </a>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Application\Resources/views/applicant/viewcourse.blade.php ENDPATH**/ ?>
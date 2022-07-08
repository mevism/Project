
<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        My Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Track progress
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
                        <h2 class="block-title fw-bold">
                            <?php echo e($course->course); ?>

                        </h2>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="py-2">
                            <p class="mb-2">Logs</p>
                        </div>
                    </div>
                    <div class="block-content text-start">
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p class="fs-sm text-success"><?php echo e($log->created_at->format('Y-M-d')); ?> - <?php echo e($log->activity); ?> by <?php echo e($log->user); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </a>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Application\Resources/views/applicant/progress.blade.php ENDPATH**/ ?>
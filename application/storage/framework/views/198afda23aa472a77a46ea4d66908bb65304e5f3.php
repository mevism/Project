


<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Intakes
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intake</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Add Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="">
            <div class="col-md-12">
                <!-- Developer Plan -->
                <div class="block block-rounded block-link-shadow" href="javascript:void(0)">
                    <div class="block-header">
                        <h2 class="block-title fw-bold text-center">Add Courses to <span class="text-success"><?php echo e(Carbon\carbon::parse($intake->intake_from)->format('M')); ?> - <?php echo e(Carbon\carbon::parse($intake->intake_to)->format('M Y')); ?> </span> Intake</h2>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="py-1">
                            <p class="mb-1 text-center">
                                Semester Duration <?php echo e(Carbon\Carbon::parse($intake->intake_from)->diffInWeeks($intake->intake_to)); ?> Weeks
                            </p>
                        </div>
                    </div>
                    <div class="block-content">

                        <form action="<?php echo e(route('department.addAvailableCourses')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <table class="table table-striped table-sm-responsive fs-sm">
                                <thead>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>Mode of Study</th>
                                    <th>Offered in</th>
                                </thead>
                                <tbody >
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(++$key); ?></td>
                                        <td>
                                            <input id = 'course_id' value="<?php echo e($course->id); ?>" data-intake = '<?php echo e($intake->id); ?>' data-code = '<?php echo e($course->course_code); ?>' type="checkbox">

                                            <label><?php echo e($course->course_name); ?></label>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p class="">
                                                    <?php echo e(++$key); ?>

                                                    <input id = 'attendance_id<?php echo e($course->id); ?>' type="checkbox" value="<?php echo e($mode->id); ?>" data-code = "<?php echo e($mode->attendance_code); ?>">
                                                    <label><?php echo e($mode->attendance_name); ?></label>
                                                </p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>

                                        <td>
                                            <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p>
                                                    <?php echo e(++$key); ?>

                                                    <input id = 'campus_id<?php echo e($course->id); ?>' type="checkbox" value="<?php echo e($campus->id); ?>">
                                                    <label><?php echo e($campus->name); ?></label>
                                                </p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-alt-success mb-4" data-toggle="click-ripple" id = 'save-course' type = 'button' onlick = "You are about to add courses to <?php echo e(Carbon\carbon::parse($intake->intake_from)->format('M')); ?> - <?php echo e(Carbon\carbon::parse($intake->intake_to)->format('M Y')); ?> intake. Are you sure you want to proceed?">Save courses</button>
                            </div>

                        </form>

                    </div>
                    <div class="block-content block-content-full bg-body-light text-center">

                    </div>
                </div>
                <!-- END Developer Plan -->
            </div>
        </div>
    </div>
<!-- END Page Content -->

<?php $__env->stopSection(); ?>


<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/COD\Resources/views/intakes/addCourses.blade.php ENDPATH**/ ?>
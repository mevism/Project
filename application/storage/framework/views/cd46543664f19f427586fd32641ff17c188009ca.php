    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
<?php $__env->startSection('content'); ?>
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                    <div class="flex-grow-0">
                        <h5 class="h5 fw-bold mb-0">
                            Courses
                        </h5>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">Courses</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                All Courses
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table id="example" class="table table-responsive table-sm table-md table-striped table-bordered fs-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>Course Name</th>
            <th>Department</th>
            <th>Period</th>
            <th>Intake</th>
            <th>Offered at</th>
            <th>View</th>
            <th class="d-none d-sm-table-cell">Apply</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td> <?php echo e($loop->iteration); ?> </td>
            <td> <?php echo e($course->course_name); ?></td>
            <td> <?php echo e($course->dept_code); ?></td>
            <td> <?php echo e($course->course_duration); ?></td>
            <td nowrap="">
            <?php echo e(Carbon\carbon::parse($course->intake_from)->format('M')); ?> - <?php echo e(Carbon\carbon::parse($course->intake_to)->format('M Y')); ?>

            </td>
            <td nowrap=""> <?php echo e($course->name); ?> </td>
            <td nowrap="">
                <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('application.viewOne', $course->available_id)); ?>">View </a>
            </td>
            <td nowrap="">
                <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('application.apply', $course->available_id)); ?>">Apply now </a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
            </div>
        </div>




    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                responsive: true,
                order: [[2, 'asc']],
                rowGroup: {
                    dataSrc: 2
                }
            } );
        } );
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Application\Resources/views/applicant/courses.blade.php ENDPATH**/ ?>
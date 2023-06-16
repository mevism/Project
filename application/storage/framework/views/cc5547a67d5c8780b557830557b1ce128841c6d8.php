<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>


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


<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        My Course
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="<?php echo e(route('student')); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Enrolled Course
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th> Course Name </th>

                    <th nowrap=""> Course Duration </th>
                    <th nowrap=""> Entry Year </th>
                    <th nowrap=""> Exit Year </th>
                    <th nowrap=""> Stage </th>
                    <th> Status </th>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$key); ?> </td>
                            <td> <?php echo e($course->studentCourse->course_name); ?></td>

                            <td> <?php echo e($course->studentCourse->courseRequirements->course_duration); ?></td>
                            <td> <?php echo e(Carbon\Carbon::parse($course->courseEntry->year_start)->format('Y')); ?></td>
                            <td> <?php echo e(Carbon\Carbon::parse($course->courseEntry->year_start)->addYears( explode(' ', $course->studentCourse->courseRequirements->course_duration)[0] )->format('Y')); ?></td>
                            <td>
                                <?php if($reg == null): ?>
                                    Not registered
                                <?php else: ?>
                                    <?php echo e('Y'.$reg->year_study.'S'.$reg->semester_study); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($course->student->status == 1): ?>
                                    <span class="text-success"> Active </span>
                                <?php else: ?>
                                <span class="text-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Student\Resources/views/courses/index.blade.php ENDPATH**/ ?>